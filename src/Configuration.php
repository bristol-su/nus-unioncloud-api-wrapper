<?php
/**
 * Configuration Class
 */

namespace Twigger\UnionCloud\API;

/**
 * Class Configuration
 *
 * @package Twigger\UnionCloud\API\Core
 */
class Configuration
{

    /**
     * The base url to make the API request to.
     *
     * Don't include a protocol or /api
     *
     * e.g 'bristol.unioncloud.org'
     *
     * @var string $baseURL
     */
    private $baseURL;

    /**
     * If true, more information about the request will be returned
     *
     * @var bool $debug
     */
    private $debug = false;




    /**
     * Get the property baseURL
     *
     * @return string
     */
    public function getBaseURL()
    {
        return $this->baseURL;
    }

    /**
     * Set the property baseURL
     *
     * @param string $baseURL
     */
    public function setBaseURL($baseURL)
    {
        $this->baseURL = 'https://'.$baseURL;
    }

    /**
     * Get the property debug
     *
     * @return bool
     */
    public function getDebug()
    {
        return $this->debug;
    }

    /**
     * Set the property debug
     *
     * @param bool $debug
     */
    public function setDebug($debug)
    {
        $this->debug = $debug;
    }

}