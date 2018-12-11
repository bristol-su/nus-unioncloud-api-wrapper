<?php
/**
 * Base Resource
 */
namespace Twigger\UnionCloud\Resource;

/**
 * Contains methods to deal with a Resource
 *
 * Class BaseResource
 *
 * @package Twigger\UnionCloud\Resource
 */
class BaseResource
{
    /**
     * Holds an array representing the resource
     *
     * @var mixed $modelParameters
     */
    protected $modelParameters;

    /**
     * Allow methods to be called by magic methods
     *
     * @param $name
     * @param $arguments
     */
    public function __call($name, $arguments)
    {
        var_dump($name);
        var_dump($arguments);
        // TODO: Implement __call() method.
    }

}