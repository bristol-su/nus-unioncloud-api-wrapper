<?php
/**
 * V0 Authenticator
 */
namespace Twigger\UnionCloud\API\Auth;

use Aws\Credentials\Credentials;
use Aws\Signature\SignatureV4;
use Carbon\Carbon;
use Psr\Http\Message\RequestInterface;
use Twigger\UnionCloud\API\Exception\Authentication\UnionCloudResponseAuthenticationException;
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
class awsAuthenticator implements IAuthenticator
{
    use Authenticates;

    /**
     * AWS Access Key
     *
     * @var string
     */
    private $accessKey;

    /**
     * AWS Secret Key
     *
     * @var string
     */
    private $secretKey;

    /**
     * AWS Api Key
     *
     * @var string
     */
    private $apiKey;

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
            'accessKey',
            'secretKey',
            'apiKey'
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
        $this->accessKey = $parameters['accessKey'];
        $this->secretKey = $parameters['secretKey'];
        $this->apiKey = $parameters['apiKey'];
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
        $options['headers']['X-Api-Key'] = $this->apiKey;
        return $options;
    }

    public function modifyRequest(RequestInterface $request)
    {
        $signer = new SignatureV4('execute-api', 'eu-west-1');
        return $signer->signRequest($request, new Credentials($this->accessKey, $this->secretKey));
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
        return false;
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
     * @inheritDoc
     */
    public function basePath()
    {
        return 'v1';
    }
}