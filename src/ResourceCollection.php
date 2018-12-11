<?php
/**
 * Resource Collection Helper Class
 */

namespace Twigger\UnionCloud;


use Twigger\UnionCloud\Exception\Resource\ResourceNotFoundException;

/**
 * Contains a wrapper for an array, providing helpful functions.
 *
 * Designed with classes implementing IResource in mind
 *
 * Class ResourceCollection
 *
 * @package Twigger\UnionCloud
 */
class ResourceCollection
{

    /**
     * @var array $resources The plain array
     */
    private $resources = [];

    /**
     * ResourceCollection constructor.
     */
    public function __construct()
    {

    }

    /**
     * Add an element to the array
     *
     * @param mixed  Resource to add
     *
     * @return void
     */
    public function addResource($resource)
    {
        $this->resources[] = $resource;
    }

    /**
     * Add multiple resources to the collection
     *
     * @param mixed[] $resources Arrays of resources to add to the collection
     */
    public function addResources($resources)
    {
        $this->resources = array_merge($this->resources, $resources);
    }

    /**
     * Return the plain array as an array
     *
     * @return array
     */
    public function toArray()
    {
        return $this->resources;
    }

    /**
     * Return a JSON representation of the resource collection
     *
     * @return string|false
     */
    public function toJson()
    {
        return json_encode($this->resources, true);
    }

    /**
     * Return the first resource in the collection
     *
     * @return mixed
     *
     * @throws ResourceNotFoundException
     */
    public function first()
    {
        if(!isset($this->resources[0]))
        {
            throw new ResourceNotFoundException('No resources were found.', 404);
        }
        return $this->resources[0];
    }

}