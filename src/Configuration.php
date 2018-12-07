<?php

namespace Twigger\UnionCloud;

class Configuration
{

    /**
    * @var string $baseURL
    */
    private $baseURL;
    /**
     * @var string $mode
     */
    private $mode = 'full';




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
    * Get the property mode
    *
    * @return string
    */
    public function getMode()
    {
        return $this->mode;
    }

    /**
    * Set the property mode
    *
    * @param string $mode
    */
    public function setMode($mode)
    {
        $this->mode = $mode;
    }

}