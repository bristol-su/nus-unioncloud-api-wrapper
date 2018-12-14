<?php
/**
 * Event Attendee Response Class
 */
namespace Twigger\UnionCloud\API\Response;

use Twigger\UnionCloud\API\Resource\EventAttendee;

/**
 * Class Event Attendee Response
 *
 * @package Twigger\UnionCloud\API\Events\EventAttendees
 */
class EventAttendeeResponse extends BaseResponse implements IResponse
{

    /**
     * Event Attendee Response  constructor.
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
        $resourceClass = EventAttendee::class;

        parent::__construct($response, $request, $requestOptions, $resourceClass);

        $this->parseResponse();

        return $this->resources;
    }

}