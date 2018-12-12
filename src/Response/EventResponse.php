<?php
/**
 * Event Response Class
 */
namespace Twigger\UnionCloud\Response;

/**
 * Class Event Response
 *
 * @package Twigger\UnionCloud\Events\Events
 */
class EventResponse extends BaseResponse implements IResponse
{

    /**
     * Event Response  constructor.
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
        $resourceClass = EventResponse::class;

        parent::__construct($response, $request, $requestOptions, $resourceClass);

        $this->parseResponse();

        return $this->resources;
    }

}