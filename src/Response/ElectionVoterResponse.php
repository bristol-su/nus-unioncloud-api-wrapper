<?php
/**
 * Election Voter Response Class
 */
namespace Twigger\UnionCloud\API\Response;

use Twigger\UnionCloud\API\Resource\ElectionVoter;

/**
 * Class Election Voter Response
 *
 * @package Twigger\UnionCloud\API\Elections\ElectionVoters
 */
class ElectionVoterResponse extends BaseResponse implements IResponse
{

    /**
     * Election Voter Response constructor.
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
        $resourceClass = ElectionVoter::class;

        parent::__construct($response, $request, $requestOptions, $resourceClass);

        $this->parseResponse();

        return $this->resources;
    }

}