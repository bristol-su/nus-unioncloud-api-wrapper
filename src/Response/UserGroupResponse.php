<?php
/**
 * User Group Response Class
 */
namespace Twigger\UnionCloud\Response;

use Twigger\UnionCloud\Resource\UserGroup;

/**
 * Class User Group Response
 *
 * @package Twigger\UnionCloud\UserGroups\UserGroups
 */
class UserGroupResponse extends BaseResponse implements IResponse
{

    /**
     * User Group Response constructor.
     *
     * Holds information about the resourceClass
     *
     * resourceClass: the class containing information about how to parse
     * the resource. Must implement BaseResource
     *
     * @param $response
     * @param $request
     * @param $requestOptions
     * @throws \Twigger\UnionCloud\Exception\Response\IncorrectResponseTypeException
     */
    public function __construct($response, $request, $requestOptions)
    {
        $resourceClass = UserGroup::class;

        parent::__construct($response, $request, $requestOptions, $resourceClass);

        $this->parseResponse();

        return $this->resources;
    }

}