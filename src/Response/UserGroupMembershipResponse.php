<?php
/**
 * UserGroup Membership Response Class
 */
namespace Twigger\UnionCloud\API\Response;

use Twigger\UnionCloud\API\Resource\UserGroupMembership;

/**
 * Class UserGroupMembershipResponse
 *
 * @package Twigger\UnionCloud\API\UserGroups\UserGroupMemberships
 */
class UserGroupMembershipResponse extends BaseResponse implements IResponse
{

    /**
     * UserGroup Membership constructor.
     *
     * Holds information about the resourceClass
     *
     * resourceClass: the class containing information about how to parse
     * the resource. Must implement BaseResource
     *
     * @param $response
     * @param $request
     * @param $requestOptions
     * @throws \Twigger\UnionCloud\API\Exception\Response\IncorrectResponseTypeException
     */
    public function __construct($response, $request, $requestOptions)
    {
        $resourceClass = UserGroupMembership::class;

        parent::__construct($response, $request, $requestOptions, $resourceClass);

        $this->parseResponse();

        return $this->resources;
    }

}