<?php
/**
 * V0 Authenticator
 */
namespace Twigger\UnionCloud\Auth;

use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Psr\Http\Message\ResponseInterface;
use Twigger\UnionCloud\Exception\Authentication\AuthenticationExpiredException;
use Twigger\UnionCloud\Exception\Authentication\AuthenticationIncorrectParameters;
use Twigger\UnionCloud\Exception\Authentication\AuthenticationParameterMissing;
use Twigger\UnionCloud\Exception\Authentication\UnionCloudResponseAuthenticationException;
use Twigger\UnionCloud\Exception\InsufficientPermissionException;
use Twigger\UnionCloud\Exception\BaseUnionCloudException;
use Twigger\UnionCloud\Traits\Authenticates;

/**
 * The authenticator for version 0 of the API.
 *
 * Version 0 uses the API Endpoint '/api/authenticate'
 * to collect an Authentication token. This is then
 * added into the header of the request in 'auth_token'
 *
 * Class v0Authenticator
 *
 * @package Twigger\UnionCloud\Auth
 */
class v0Authenticator implements IAuthenticator
{
    use Authenticates;

    // Define the configuration variables

    /**
     * User Email
     *
     * @var string
     */
    private $email;
    /**
     * User Password
     *
     * @var string
     */
    private $password;
    /**
     * User App ID
     *
     * @var string
     */
    private $appID;
    /**
     * User App Password
     *
     * @var string
     */
    private $appPassword;
    /**
     * User Auth Token
     *
     * @var string
     */
    private $authToken;
    /**
     * User Union ID
     *
     * @var string
     */
    private $union_id;
    /**
     * Expiry of the auth token
     *
     * @var integer
     */
    private $expires;

    /**
     * Ensure the necessary parameters for making a request
     * are present within the $parameters array.
     *
     * Uses the Authenticates trait for $this->checkParameterIndices.
     * This function simply ensures the required parameters are present
     * in the parameters from the user.
     *
     * @param array $parameters
     *
     * @return bool
     */
    public function validateParameters($parameters)
    {
        $requiredParameters = [
            'email',
            'password',
            'appID',
            'appPassword',
        ];
        return $this->checkParameterIndices($requiredParameters, $parameters);
    }

    /**
     * Set the authentication parameters
     *
     * Save the authentication configuration
     * by storing the user values in class properties
     *
     * @param array $parameters
     */
    public function setParameters($parameters)
    {

        $this->email = $parameters['email'];
        $this->password = $parameters['password'];
        $this->appID = $parameters['appID'];
        $this->appPassword = $parameters['appPassword'];
    }

    /**
     * Make a call to the api/authenticate endpoint. Ensure the
     * authentication token is received and save it.
     *
     * @param string $baseURL
     *
     * @return void
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws UnionCloudResponseAuthenticationException
     */
    public function authenticate($baseURL)
    {
        $client = new Client(['base_uri' => $baseURL]);

        try {
            $response = $client->request(
                'POST',
                '/api/authenticate',
                $this->getDefaultOptions()
            );
        } catch (RequestException $e) { // TODO remove this check below. We can't throw a 401 on auth!
            if(!$e->getCode() === 401)
            {
                throw new AuthenticationExpiredException('Auth Token Expired', 401, $e);
            }
            // Add on custom exceptions to the stack
            $this->throwForStatus($e);
        }

        $this->extractAuthToken($response);
    }

    /**
     * Build up an array to pass in the body of the authentication request
     *
     * @return array
     */
    private function createBodyArray()
    {
        return [
            'email' => $this->email,
            'password' => $this->password,
            'app_id' => $this->appID,
            'date_stamp' => Carbon::now()->timestamp,
            'hash' => hash('sha256',
                $this->email.$this->password.$this->appID.Carbon::now()->timestamp.$this->appPassword
            ),
        ];
    }

    /**
     * Get the options for the authentication request.
     *
     * @return array GuzzleHTTP option array
     */
    private function getDefaultOptions()
    {
        return [
            'form_params' => $this->createBodyArray(),
            'headers' => [
                "User-Agent" => "Twigger-UnionCloud-API-Wrapper",
                "Content-Type" => "multipart/form-data",
                "Accept-Version" => "v1",
            ],
            'http_errors' => true,
            'verify' => __DIR__ . '/../../unioncloud.pem',
            'debug' => false
        ];
    }

    /**
     * Check the body of the authentication request and ensure no errors were produced.
     *
     * @param RequestException $e
     *
     * @throws UnionCloudResponseAuthenticationException
     */
    private function throwForStatus(RequestException $e)
    {
        $response = $e->getResponse();
        $body = $response->getBody()->getContents();
        $code = $response->getStatusCode();


        // If there's a body, we may be able to process the error messages
        if(strlen($body) > 0)
        {
            // Get the message body
            try {
                $responseBody = json_decode($body, true);
            } catch (\Exception $decodeError) {
                throw new UnionCloudResponseAuthenticationException('Invalid response body returned in Authentication', 500, $e);
            }

            // Parse the message error. For Authentication, this is a message and a code
            try {
                $errorMessage = $responseBody['error']['message'];
                $errorCode = $responseBody['error']['code'];
            } catch (\Exception $e)
            {
                throw new UnionCloudResponseAuthenticationException('Incorrect response body returned in Authentication', 500);
            }

            // If we have a description of the error, set that to the exception message.
            // If we don't have a description, throw the error as is

            $unionCloudErrorCodes = $this->getAuthFailureCodes();

            if(array_key_exists($errorCode, $unionCloudErrorCodes))
            {
                $throwable = $unionCloudErrorCodes[$errorCode]['throwable'];
                throw new $throwable($unionCloudErrorCodes[$errorCode]['message'], $code, $e, $errorCode);
            }

            throw new UnionCloudResponseAuthenticationException($errorMessage, $code, $e, $errorCode);
        }


    }

    /**
     * Get human readable error messages corresponding to those on the
     * UnionCloud API Documentation
     *
     * @return array
     */
    private function getAuthFailureCodes()
    {
        return [
            '401' => [
                'message' => 'Authentication Failed: Invalid Email or Password',
                'throwable' => AuthenticationIncorrectParameters::class,
            ],
            '402' => [
                'message' => 'Authentication Failed: Invalid Hash, App ID or App Password',
                'throwable' => AuthenticationIncorrectParameters::class,
            ],
            '403' => [
                'message' => 'User doesn\'t have the correct permissions to use the API',
                'throwable' => InsufficientPermissionException::class,
            ],
            '404' => [
                'message' => 'Unknown error whilst authenticating',
                'throwable' => UnionCloudResponseAuthenticationException::class
            ],
            '405' => [
                'message' => 'Parameters missing from the authentication request',
                'throwable' => AuthenticationParameterMissing::class
            ],
        ];
    }

    /**
     * Get the auth token from the API response from UnionCloud
     *
     * @param ResponseInterface $response
     * @throws UnionCloudResponseAuthenticationException
     */
    private function extractAuthToken(ResponseInterface $response)
    {
        // Get the message body
        try {
            $responseBody = json_decode($response->getBody()->getContents(), true);
        } catch (\Exception $decodeError) {
            throw new UnionCloudResponseAuthenticationException('Invalid response body returned in Authentication', 500, $decodeError);
        }

        try {
            $this->authToken = $responseBody['response']['auth_token'];
            $this->expires = $responseBody['response']['expires'];
            $this->union_id = $responseBody['response']['union_id'];
        } catch (\Exception $e) {
            throw new UnionCloudResponseAuthenticationException('Couldn\'t find required Auth Token parameters in the response', 500, $e);
        }
    }

    /**
     * Get the auth token
     *
     * @return string
     */
    private function getAuthToken()
    {
        return $this->authToken;
    }

    /**
     * Add authentication into the request headers.
     *
     * @param $options
     * @return array|mixed
     */
    public function addAuthentication($options)
    {
        $options = $this->addHeader($options, 'auth_token', $this->getAuthToken());
        return $options;
    }
}