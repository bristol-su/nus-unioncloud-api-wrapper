<?php
/**
 * User Group Folder Response Class
 */
namespace Twigger\UnionCloud\API\Response;

use Twigger\UnionCloud\API\Resource\UserGroupFolder;

/**
 * Class User Group Folder Response
 *
 * @package Twigger\UnionCloud\API\UserGroups\UserGroupFolders
 */
class UserGroupFolderResponse extends BaseResponse implements IResponse
{

    /**
     * User Group Folder Response  constructor.
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
        $resourceClass = UserGroupFolder::class;

        parent::__construct($response, $request, $requestOptions, $resourceClass);

        $this->parseResponse();

        return $this->resources;
    }

}