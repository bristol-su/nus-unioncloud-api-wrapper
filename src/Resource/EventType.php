<?php
/**
 * Event Type Resource
 */
namespace Twigger\UnionCloud\Resource;

use phpDocumentor\Reflection\DocBlock;
use Twigger\UnionCloud\Exception\Resource\ResourceNotFoundException;
use Twigger\UnionCloud\ResourceCollection;

/**
 * Class Event Type
 *
 * @package Twigger\UnionCloud\Events\EventTypes
 *
 */
class EventType extends BaseResource implements IResource
{

    /**
     * Enable casting for this resource
     *
     * @var array
     *
     * @see BaseResource::casts
     */
    protected $casts = [
    ];

    /**
     * Enable further casting with multiple attributes
     *
     * @var array
     *
     * @see BaseResource::$customCasts
     */
    protected $customCasts = [
    ];

    /**
     * Set the model parameters
     *
     * Event Type constructor.
     *
     * @throws ResourceNotFoundException
     *
     * @param $resource
     */
    public function __construct($resource)
    {
        parent::__construct($resource);

    }
}