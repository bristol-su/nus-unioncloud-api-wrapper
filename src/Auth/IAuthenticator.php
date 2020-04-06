<?php
/**
 * IAuthenticator Class
 */
namespace Twigger\UnionCloud\API\Auth;

use Psr\Http\Message\RequestInterface;

/**
 * Interface to guide the creation of an authenticator.
 *
 * An authenticator is the class that actually deals with
 * Authentications. The Authentication wrapper interacts with it.
 *
 * Interface IAuthenticator
 * @package Twigger\UnionCloud\API\Core\Authentications
 */
interface IAuthenticator
{

    /**
     * Get the base path for the authenticator
     * 
     * @return string e.g. api, v1
     */
    public function basePath();

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
     * @return bool
     */
    public function validateParameters($parameters);

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
     * @return array $options (transformed)
     */
    public function addAuthentication($options);

    /**
     * Authentication method
     *
     * This method should make any necessary API calls etc
     * required for authentication.
     *
     * @param string $baseURL Base URL for making API calls
     * @param array $options Additional options for the Guzzle client
     *
     * @return void
     */
    public function authenticate($baseURL, $options = []);

    /**
     * Determine if the authenticate function needs to be called.
     *
     * For example, you could check an API key is present and
     * the expiry is still in the future.
     *
     * @return bool
     */
    public function needsRefresh();

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
     * @return void
     */
    public function setParameters($parameters);

    /**
     * Modify the completed request in any way before sending it
     * 
     * @param RequestInterface $request
     * @return mixed
     */
    public function modifyRequest(RequestInterface $request);
}