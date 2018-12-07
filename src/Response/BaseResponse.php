<?php

namespace Twigger\UnionCloud\Response;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Twigger\UnionCloud\Exception\Response\IncorrectResponseTypeException;

class BaseResponse
{

    private $response;
    private $request;
    private $rawData;

    /**
     * BaseResponse constructor.
     *
     * @param Response $response
     * @param Request $request
     */
    public function __construct($response, $request)
    {
        if( ! $response instanceof Response)
        {
            throw new IncorrectResponseTypeException();
        }
        // TODO check request type

        $this->response = $response;
        $this->request = $request;


        // Process metadata
            // Status Code
            // Raw Response Body
            // Raw Data
            // Runtime
            // Total Records
            // Total Pages
            // Records per Page
            // Status Code
            // Success status

        // Create models
            // Call 'createModel' function from implemetation
            // Pass it a model at a time.
            //

        $this->setRawData($response->getBody()->getContents());
    }

    /**
     * Get the data from the API call
     *
     * @return array
     */
    public function getRawData()
    {
        return $this->rawData;
    }

    /**
     * Parse and set the raw data returned from the request.
     *
     * @param array|string $rawData Raw data returned in a request. Array or JSON encoded array.
     */
    protected function setRawData($rawData)
    {
        if(is_string($rawData))
        {
            $rawData = json_decode($rawData, true);
        }
        $this->rawData = $rawData;
    }

    public function getRawRequest()
    {
        return $this->request;
    }

    public function getRawResponse()
    {
        return $this->response;
    }
}