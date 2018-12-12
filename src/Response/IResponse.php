<?php
/**
 * IResponse class
 */

namespace Twigger\UnionCloud\Response;

/**
 * Recipe for creating a response class. You should
 * have one response class per resource
 *
 * Interface IResponse
 *
 * @package Twigger\UnionCloud\Core\Responses
 */
interface IResponse
{

    /**
     * IResponse constructor.
     *
     * Holds information about the resourceClass
     *
     * resourceClass: the class containing information about how to parse
     * the resource. Must implement BaseResource
     *
     * Example Implementation
     *
     * public function __construct($response, $request, $requestOptions)
     * {
     *      $resourceClass = User::class;
     *      parent::__construct($response, $request, $requestOptions, $resourceClass);
     *      $this->parseResponse(); // Method from BaseResponse
     *      return $this->resources;
     *  }
     *
     * @param $response
     * @param $request
     * @param $requestOptions
     * @throws \Twigger\UnionCloud\Exception\Response\IncorrectResponseTypeException
     */
    public function __construct($response, $request, $requestOptions);

}