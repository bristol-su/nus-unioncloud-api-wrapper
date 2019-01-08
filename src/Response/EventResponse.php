<?php
/**
 * Event Response Class
 */
namespace Twigger\UnionCloud\API\Response;

use Twigger\UnionCloud\API\Resource\Event;
/**
 * Class Event Response
 *
 * @package Twigger\UnionCloud\API\Events\Events
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
     * @throws \Twigger\UnionCloud\API\Exception\Response\IncorrectResponseTypeException
     */
    public function __construct($response, $request, $requestOptions)
    {
        $resourceClass = Event::class;

        parent::__construct($response, $request, $requestOptions, $resourceClass);

        $this->parseResponse();

        return $this->resources;
    }

}
