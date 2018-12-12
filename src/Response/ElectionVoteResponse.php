<?php
/**
 * Election Vote Response Class
 */
namespace Twigger\UnionCloud\Response;

use Twigger\UnionCloud\Resource\ElectionVote;

/**
 * Class Election Vote Response
 *
 * @package Twigger\UnionCloud\Elections\ElectionVotes
 */
class ElectionVoteResponse extends BaseResponse implements IResponse
{

    /**
     * Election Vote Response constructor.
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
        $resourceClass = ElectionVote::class;

        parent::__construct($response, $request, $requestOptions, $resourceClass);

        $this->parseResponse();

        return $this->resources;
    }

}