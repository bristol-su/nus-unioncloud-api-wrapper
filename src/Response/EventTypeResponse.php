<?php
/**
 * Event Type Response Class
 */
namespace Twigger\UnionCloud\Response;

use Twigger\UnionCloud\Resource\EventType;

/**
 * Class Event Type Response
 *
 * @package Twigger\UnionCloud\Events\EventTypes
 */
class EventTypeResponse extends BaseResponse implements IResponse
{

    /**
     * Event Type Response constructor.
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
        $resourceClass = EventType::class;

        parent::__construct($response, $request, $requestOptions, $resourceClass);

        $this->parseResponse();

        return $this->resources;
    }

}