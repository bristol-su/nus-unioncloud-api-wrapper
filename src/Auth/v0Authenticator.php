<?php

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
use Twigger\UnionCloud\Exception\UnionCloudException;
use Twigger\UnionCloud\Traits\Authenticates;

class v0Authenticator implements IAuthenticator
{
    use Authenticates;

    // Define the configuration variables
    protected $email;
    protected $password;
    protected $appID;
    protected $appPassword;
    protected $apiURL;
    private $authToken;
    private $union_id;
    private $expires;

    public function validateParameters($parameters)
    {
        $requiredParameters = [
            'email',
            'password',
            'appID',
            'appPassword',
            'apiURL',
        ];
        return $this->checkParameterIndices($requiredParameters, $parameters);
    }

    /**
     * @param array $parameters
     *
     * @throws AuthenticationParameterMissing
     */
    public function setParameters($parameters)
    {

        // Ensure the parameters are valid
        if(!$this->validateParameters($parameters))
        {
            throw new AuthenticationParameterMissing();
        };

        $this->email = $parameters['email'];
        $this->password = $parameters['password'];
        $this->appID = $parameters['appID'];
        $this->appPassword = $parameters['appPassword'];
        $this->apiURL = $parameters['apiURL'];
    }

    protected $rrrr;
    /**
     * @return bool|mixed|\Psr\Http\Message\ResponseInterface
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws UnionCloudResponseAuthenticationException
     */
    public function authenticate()
    {
        $client = new Client(['base_uri' => $this->apiURL]);

        try {
            $response = $client->request(
                'POST',
                '/api/authenticate',
                $this->getDefaultOptions()
            );
        } catch (RequestException $e) {
            if(!$e->getCode() === 401)
            {
                throw new AuthenticationExpiredException('Auth Token Expired', 401, $e);
            }
            // Add on custom exceptions to the stack
            $this->throwForStatus($e);
        }

        $this->extractAuthToken($response);

        //var_dump($response);
        // Save the API key
    }



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

    public function addAuthentication($options)
    {
        $options['auth_token'] = $this->authToken;
        return $options;
    }
}