<?php
/**
 * Event Resource
 */
namespace Twigger\UnionCloud\Resource;

use phpDocumentor\Reflection\DocBlock;
use Twigger\UnionCloud\Exception\Resource\ResourceNotFoundException;
use Twigger\UnionCloud\ResourceCollection;

/**
 * Class User Group Membership
 *
 * @package Twigger\UnionCloud\Events\Events
 *
 */
class Event extends BaseResource implements IResource
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
     * Event constructor.
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