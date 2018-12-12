<?php
/**
 * Election Position Response Class
 */
namespace Twigger\UnionCloud\Response;


use Twigger\UnionCloud\Resource\ElectionPosition;

/**
 * Class Election Response Position
 *
 * @package Twigger\UnionCloud\Elections\ElectionPositions
 */
class ElectionPositionResponse extends BaseResponse implements IResponse
{

    /**
     * Election Position Response constructor.
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
        $resourceClass = ElectionPosition::class;

        parent::__construct($response, $request, $requestOptions, $resourceClass);

        $this->parseResponse();

        return $this->resources;
    }

}