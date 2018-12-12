<?php
/**
 * Election Standing Response Class
 */
namespace Twigger\UnionCloud\Response;


use Twigger\UnionCloud\Resource\ElectionStanding;

/**
 * Class Election Standing Response
 *
 * @package Twigger\UnionCloud\Elections\ElectionStandings
 */
class ElectionStandingResponse extends BaseResponse implements IResponse
{

    /**
     * Election Standing Response constructor.
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
        $resourceClass = ElectionStanding::class;

        parent::__construct($response, $request, $requestOptions, $resourceClass);

        $this->parseResponse();

        return $this->resources;
    }

}