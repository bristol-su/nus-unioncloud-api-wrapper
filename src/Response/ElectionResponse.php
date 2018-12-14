<?php
/**
 * Election Response Class
 */
namespace Twigger\UnionCloud\API\Response;


use Twigger\UnionCloud\API\Resource\Election;

/**
 * Class Election Response
 *
 * @package Twigger\UnionCloud\API\Elections\Elections
 */
class ElectionResponse extends BaseResponse implements IResponse
{

    /**
     * Election Response constructor.
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
        $resourceClass = Election::class;

        parent::__construct($response, $request, $requestOptions, $resourceClass);

        $this->parseResponse();

        return $this->resources;
    }

}