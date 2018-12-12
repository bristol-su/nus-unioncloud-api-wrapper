<?php
/**
 * UserGroup Membership Resource
 */
namespace Twigger\UnionCloud\Resource;

use phpDocumentor\Reflection\DocBlock;
use Twigger\UnionCloud\Exception\Resource\ResourceNotFoundException;
use Twigger\UnionCloud\ResourceCollection;

/**
 * Class User Group Membership
 *
 * @package Twigger\UnionCloud\UserGroups\UserGroupMemberships
 *
 */
class UserGroupMembership extends BaseResource implements IResource
{

    /**
     * Enable casting for this resource
     *
     * @var array
     *
     * @see BaseResource::casts
     */
    protected $casts = [
        'ugmUpdatedAt' => 'date'
    ];

    /**
     * Enable further casting with multiple attributes
     *
     * @var array
     *
     * @see BaseResource::$customCasts
     */
    protected $customCasts = [
        'usergroup|'.UserGroup::class => [
            'ugId' => ' ug_id',
            'ugName' => 'ug_name',
            'ugType' => 'ug_type'
        ],
        'user|'.User::class => [
            'id' => 'id',
            'uid' => 'uid',
            'forename' => 'forename',
            'surname' => 'surname',
            'email' => 'email',
            'updatedAt' => 'updated_at',
        ],
        'event|'.Event::class => [
            'eventId' => 'event_id',
            'eventName' => 'event_name',
            'startDate' => 'start_date',
            'endDate' => 'end_date'
        ]
    ];

    /**
     * Set the model parameters
     *
     * UserGroup Membership constructor.
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