<?php
/**
 * Event Question Resource
 */
namespace Twigger\UnionCloud\API\Resource;

use phpDocumentor\Reflection\DocBlock;
use Twigger\UnionCloud\API\Exception\Resource\ResourceNotFoundException;
use Twigger\UnionCloud\API\ResourceCollection;

/**
 * Class Event Question
 *
 * @package Twigger\UnionCloud\API\Events\EventQuestions
 *
 */
class EventQuestion extends BaseResource implements IResource
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
     * Event Question constructor.
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