<?php
/**
 * User Response Class
 */
namespace Twigger\UnionCloud\Response;

use Twigger\UnionCloud\Resource\User;

/**
 * Class UserResponse
 *
 * @package Twigger\UnionCloud
 */
class UserResponse extends BaseResponse implements IResponse
{

    /**
     * UserResponse constructor.
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
        $resourceClass = User::class;

        parent::__construct($response, $request, $requestOptions, $resourceClass);

        $this->parseResponse();

        return $this->resources;
    }

}