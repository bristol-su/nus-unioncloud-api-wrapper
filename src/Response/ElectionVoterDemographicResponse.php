<?php
/**
 * Election Voter Demographic Response Class
 */
namespace Twigger\UnionCloud\Response;


use Twigger\UnionCloud\Resource\ElectionVoterDemographic;

/**
 * Class Election Voter Demographic Response
 *
 * @package Twigger\UnionCloud\Elections\ElectionVoterDemographics
 */
class ElectionVoterDemographicResponse extends BaseResponse implements IResponse
{

    /**
     * Election Voter Demographic Response constructor.
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
        $resourceClass = ElectionVoterDemographic::class;

        parent::__construct($response, $request, $requestOptions, $resourceClass);

        $this->parseResponse();

        return $this->resources;
    }

}