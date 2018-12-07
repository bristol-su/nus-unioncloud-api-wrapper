<?php

namespace Twigger\UnionCloud\Traits;

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
    public function checkParameterIndices($keys, $parameters)
    {
        foreach ($keys as $key) {
            if(!array_key_exists($key, $parameters)){
                return false;
            }
        }

        return true;
    }

    /**
     * Add header to guzzle HTTP options
     */
    public function addHeader($options, $headerName, $headerValue)
    {
        $options['headers'][$headerName] = $headerValue;
        return $options;
    }
}