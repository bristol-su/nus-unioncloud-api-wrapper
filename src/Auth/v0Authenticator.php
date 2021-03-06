<?php
/**
 * V0 Authenticator
 */
namespace Twigger\UnionCloud\API\Auth;

use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Twigger\UnionCloud\API\Exception\Authentication\AuthenticationIncorrectParameters;
use Twigger\UnionCloud\API\Exception\Authentication\AuthenticationParameterMissing;
use Twigger\UnionCloud\API\Exception\Authentication\UnionCloudResponseAuthenticationException;
use Twigger\UnionCloud\API\Exception\InsufficientPermissionException;
use Twigger\UnionCloud\API\Exception\BaseUnionCloudException;
use Twigger\UnionCloud\API\Traits\Authenticates;

/**
 * The authenticator for version 0 of the API.
 *
 * Version 0 uses the API Endpoint '/api/authenticate'
 * to collect an Authentication token. This is then
 * added into the header of the request in 'auth_token'
 *
 * Class v0Authenticator
 *
 * @package Twigger\UnionCloud\API\Authenticators
 */
class v0Authenticator implements IAuthenticator
{
    use Authenticates;

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
     * Expiry of the Auth Token
     *
     * @var Carbon
     */
    private $expires;

    /*
    |--------------------------------------------------------------------------
    | Inherited from the Authenticator
    |--------------------------------------------------------------------------
    |
    | These functions are implementations of the Authenticator Interface
    |
    */

    /**
     * Validate the parameters used to authenticate
     *
     * This function should ensure the associative array
     * $parameters contains the parameters for a successful
     * authentication.
     *
     * If not all the parameters are present, return false
     *
     * @param array $parameters
     *
     * @see IAuthenticator::validateParameters()
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
        return $this->authArrayKeysExist($requiredParameters, $parameters);
    }

    /**
     * Save the parameters into the Authenticator class
     *
     * This function takes an associative array of authentication
     * parameters required by the authenticator, and
     * saves them to be used later.
     *
     * For example, if the only parameter required by the
     * API was an API key, we could implement this function
     * in the following:
     *
     * private $apiKey;
     *
     * public function setParameters($parameters)
     * {
     *      $this->apiKey = $parameters['api_key'];
     * }
     *
     * You may assume all the parameters are present, since we
     * will call your 'validateParameters' function first.
     *
     * @param array $parameters
     *
     * @see IAuthenticator::setParameters()
     *
     * @return void
     */
    public function setParameters($parameters)
    {

        $this->email = $parameters['email'];
        $this->password = $parameters['password'];
        $this->appID = $parameters['appID'];
        $this->appPassword = $parameters['appPassword'];
    }

    /**
     * Authentication method
     *
     * This method should make any necessary API calls etc
     * required for authentication.
     *
     * @param string $baseURL Base URL for making API calls
     * @param array $options Additional options for the Guzzle HTTP client
     *
     * @see IAuthenticator::authenticate()
     *
     * @throws BaseUnionCloudException
     * @throws UnionCloudResponseAuthenticationException
     * @throws \GuzzleHttp\Exception\GuzzleException
     *
     * @return void
     */
    public function authenticate($baseURL, $options = [])
    {
        $client = new Client(array_merge(['base_uri' => $baseURL], $options));
        try {
            $response = $client->request(
                'POST',
                '/api/authenticate',
                $this->getDefaultOptions()
            );
        } catch (RequestException $e) {
            // Add on custom exceptions to the stack
            $this->throwForStatus($e);
        }

        $this->extractAuthToken($response);
    }

    /**
     * Transform the Guzzle HTTP request options to include the authentication
     *
     * This method receives an array in the form required by the
     * GuzzleHttp Client. You may manipulate this in any valid way
     * to add authentication.
     *
     * For example, adding an auth token to the headers may be done as so:
     *
     * public function addAuthentication($options)
     * {
     *      $options = $this->addHeader($options, $this->authToken);
     *      return $options;
     * }
     *
     * In this the Authenticates trait was used, which contains helpful
     * methods for writing Authenticators.
     *
     * @param $options
     *
     * @see IAuthenticator::addAuthentication()
     *
     * @return array $options (transformed)
     */
    public function addAuthentication($options)
    {
        $options = $this->addHeader($options, 'auth_token', $this->authToken);
        return $options;
    }

    /**
     * Determine if the authenticate function needs to be called.
     *
     * For example, you could check an API key is present and
     * the expiry is still in the future.
     *
     * @see IAuthenticator::needsRefresh()
     *
     * @return bool
     */
    public function needsRefresh()
    {
        if($this->expires === null)
        {
            return true;
        } elseif ($this->expires instanceof Carbon)
        {
            return ! $this->expires->isFuture();
        }
        return true;
    }

    /*
    |--------------------------------------------------------------------------
    | Helper Functions
    |--------------------------------------------------------------------------
    |
    | Functions to aid the execution of this class
    |
    */



    /**
     * Build up an array to pass in the body of the authentication request
     *
     * This is simply an associative array containing all the
     * parameters required by the '/api/authenticate' endpoint.
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
     * This is an associative array that matches the format
     * specified by GuzzleHTTP
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
            'verify' => __DIR__.'/../../unioncloud.pem',
            'debug' => false
        ];
    }

    /**
     * Check the body of the response to add any additional information to the exception
     *
     * The checks performed are as follows:
     *      - The response body shouldn't be null
     *      - The request body should be a JSON response
     *      - The request body should contain an element called 'error'
     *          - If this is the case, we can use the error codes
     *            as documented in the UnionCloud API documentation
     *            to provide additional information
     *
     * @param RequestException $e
     *
     * @throws BaseUnionCloudException
     * @throws UnionCloudResponseAuthenticationException
     */
    private function throwForStatus(RequestException $e)
    {

        $response = $e->getResponse();
        if ($response === null)
        {
            throw new BaseUnionCloudException('No response received from UnionCloud', 500, $e);
        }
        $body = $response->getBody()->getContents();
        $code = $response->getStatusCode();


        // If there's a body, we may be able to process the error messages
        if (strlen($body) > 0)
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
                throw new UnionCloudResponseAuthenticationException('Incorrect response body returned in Authentication'.json_encode($responseBody), 500);
            }

            // If we have a description of the error, set that to the exception message.
            // If we don't have a description, throw the error as is

            $unionCloudErrorCodes = $this->getAuthFailureCodes();

            if (array_key_exists($errorCode, $unionCloudErrorCodes))
            {
                $throwable = $unionCloudErrorCodes[$errorCode]['throwable'];
                throw new $throwable($unionCloudErrorCodes[$errorCode]['message'], $code, $e, $errorCode);
            }

            throw new UnionCloudResponseAuthenticationException($errorMessage, $code, $e, $errorCode);
        }

        throw $e;
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
     * This will also process the expiry and union ID, and save
     * them within the Authenticator for later use.
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
            $this->expires = Carbon::now()->addSeconds($responseBody['response']['expires']);
            $this->union_id = $responseBody['response']['union_id'];
        } catch (\Exception $e) {
            throw new UnionCloudResponseAuthenticationException('Couldn\'t find required Auth Token parameters in the response', 500, $e);
        }
    }

    public function modifyRequest(RequestInterface $request)
    {
        return $request;
    }

    /**
     * @inheritDoc
     */
    public function basePath()
    {
        return 'api';
    }
}