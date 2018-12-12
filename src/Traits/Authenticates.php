<?php
/**
 * Authenticates Trait
 */
namespace Twigger\UnionCloud\Traits;

/**
 * Helper functions for Authenticators
 *
 * Includes:
 *      an array_keys_exist function, to validate parameters are all given
 *      A header function to add a header to Guzzle HTTP options
 *
 * @package Twigger\UnionCloud\Core\Traits
 */
trait Authenticates
{
    /**
     * Checks all the keys are present in the parameter array
     *
     * This can be used for validation. Create an array of all required fields, and pass them in along
     * with the the parameters passed in by the user to ensure all are present
     *
     * @param array $keys Array of keys that should be present in the configuration
     * @param array $parameters The parameters passed from the user
     *
     * @return bool
     */
    public function authArrayKeysExist($keys, $parameters)
    {
        foreach ($keys as $key) {
            if (!array_key_exists($key, $parameters)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Add header to Guzzle HTTP options array
     *
     * @param array $options An options array
     * @param string $headerName Name of the header to input into the Guzzle options array
     * @param mixed $headerValue Value of the header
     *
     * @return mixed options array (transformed)
     */
    public function addHeader($options, $headerName, $headerValue)
    {
        $options['headers'][$headerName] = $headerValue;
        return $options;
    }
}