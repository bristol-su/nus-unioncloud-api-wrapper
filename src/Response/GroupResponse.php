<?php
/**
 * Group Response Class
 */
namespace Twigger\UnionCloud\Response;

use Twigger\UnionCloud\Resource\Group;

/**
 * Class Group Response
 *
 * @package Twigger\UnionCloud\Groups\Groups
 */
class GroupResponse extends BaseResponse implements IResponse
{

    /**
     * Group Response constructor.
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
        $resourceClass = Group::class;

        parent::__construct($response, $request, $requestOptions, $resourceClass);

        $this->parseResponse();

        return $this->resources;
    }

}