<?php
/**
 * Event Question Response Class
 */
namespace Twigger\UnionCloud\Response;

use Twigger\UnionCloud\Resource\EventQuestion;

/**
 * Class Event Question Response
 *
 * @package Twigger\UnionCloud\Events\EventQuestions
 */
class EventQuestionResponse extends BaseResponse implements IResponse
{

    /**
     * Event Question Response constructor.
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
        $resourceClass = EventQuestion::class;

        parent::__construct($response, $request, $requestOptions, $resourceClass);

        $this->parseResponse();

        return $this->resources;
    }

}