<?php
/**
 * Programme Response Class
 */
namespace Twigger\UnionCloud\Response;

use Twigger\UnionCloud\Resource\Programme;

/**
 * Class Programme Response
 *
 * @package Twigger\UnionCloud\Programmes\Programmes
 */
class ProgrammeResponse extends BaseResponse implements IResponse
{

    /**
     * Programme Response constructor.
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
        $resourceClass = Programme::class;

        parent::__construct($response, $request, $requestOptions, $resourceClass);

        $this->parseResponse();

        return $this->resources;
    }

}