<?php
/**
 * Event Ticket Response Class
 */
namespace Twigger\UnionCloud\Response;

/**
 * Class UserResponse
 *
 * @package Twigger\UnionCloud\Events\EventTickets
 */
class EventTicketResponse extends BaseResponse implements IResponse
{

    /**
     * Event Ticket Response constructor.
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
        $resourceClass = EventTicketResponse::class;

        parent::__construct($response, $request, $requestOptions, $resourceClass);

        $this->parseResponse();

        return $this->resources;
    }

}