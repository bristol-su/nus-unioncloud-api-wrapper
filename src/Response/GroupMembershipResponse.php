<?php
/**
 * Group Membership Response Class
 */
namespace Twigger\UnionCloud\API\Response;

use Twigger\UnionCloud\API\Resource\GroupMembership;

/**
 * Class Group Membership Response
 *
 * @package Twigger\UnionCloud\API\Groups\GroupMemberships
 */
class GroupMembershipResponse extends BaseResponse implements IResponse
{

    /**
     * Group Membership Response constructor.
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
        $resourceClass = GroupMembership::class;

        parent::__construct($response, $request, $requestOptions, $resourceClass);

        $this->parseResponse();

        return $this->resources;
    }

}