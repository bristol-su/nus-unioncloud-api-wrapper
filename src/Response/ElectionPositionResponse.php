<?php
/**
 * Election Position Response Class
 */
namespace Twigger\UnionCloud\API\Response;


use Twigger\UnionCloud\API\Resource\ElectionPosition;

/**
 * Class Election Response Position
 *
 * @package Twigger\UnionCloud\API\Elections\ElectionPositions
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
     * @throws \Twigger\UnionCloud\API\Exception\Response\IncorrectResponseTypeException
     */
    public function __construct($response, $request, $requestOptions)
    {
        $resourceClass = ElectionPosition::class;

        parent::__construct($response, $request, $requestOptions, $resourceClass);

        $this->parseResponse();

        return $this->resources;
    }

}