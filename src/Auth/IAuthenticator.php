<?php

namespace Twigger\UnionCloud\Auth;

interface IAuthenticator
{

    /**
     * Validate the parameters used to authenticate
     *
     * If not all the parameters are present, return false
     *
     * @param array $parameters
     * @return bool
     */
    public function validateParameters($parameters);

    /**
     * Save the parameters into the Authenticator class
     *
     * @param array $parameters
     *
     * @return void
     */
    public function setParameters($parameters);

    /**
     * This method will be called before calling addAuthentication. Gives you a chance to make any authentication API requests
     *
     *
     * @return bool
     */
    public function authenticate();

    /**
     * Transform the Guzzle HTTP Request Options to include the authentication
     *
     * Make sure you use the Authenticates trait. This includes methods for adding headers.
     *
     * @param $options
     * @return array $options (transformed)
     */
    public function addAuthentication($options);

}