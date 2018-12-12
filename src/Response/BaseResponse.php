<?php
/**
 * BaseResponse class
 */
namespace Twigger\UnionCloud\Response;

use Carbon\Carbon;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Twigger\UnionCloud\ResourceCollection;
use Twigger\UnionCloud\Exception\Response\IncorrectResponseTypeException;

/**
 * Handle processing a response and creating Resource classes out of the response
 *
 * Class BaseResponse
 *
 * @package Twigger\UnionCloud\Core\Responses
 */
class BaseResponse
{

    /*
   |--------------------------------------------------------------------------
   | Debug Parameters
   |--------------------------------------------------------------------------
   |
   | Parameters to aid with debugging
   |
   */
    /**
     * Response from GuzzleHTTP
     * @var Response
     */
    private $response;

    /**
     * Request from GuzzleHTTP
     *
     * @var Request
     */
    private $request;

    /**
     * Data returned from the API
     *
     * @var array
     */
    private $rawData;

    /**
     * MetaData returned from the API
     * @var array
     */
    private $rawMeta;

    /**
     * Options passed into Guzzle HTTP
     * @var array
     */
    private $requestOptions;















    /*
   |--------------------------------------------------------------------------
   | MetaData Parameters
   |--------------------------------------------------------------------------
   |
   | Parameters to do with the metadata
   |
   */
    /**
     * Status code of the request
     *
     * @var int
     */
    private $statusCode;

    /**
     * X-Request-ID from the response
     * @var string
     */
    private $xRequestID;

    /**
     * RunTime on the UnionCloud server
     * @var double
     */
    private $runTime;

    /**
     * Date in the HTTP Header
     *
     * @var Carbon
     */
    private $responseDate;

    /**
     * Number of records per page
     *
     * @var int
     */
    private $recordsPerPage;

    /**
     * Total pages returned
     * @var int
     */
    private $totalPages;

    /**
     * Total number of records returned
     * @var int
     */
    private $totalRecords;

    /**
     * Number of failed records
     *
     * @var int
     */
    private $failedRecords;

    /**
     * Number of successful records
     *
     * @var int
     */
    private $successfulRecords;

    /**
     * Is the request able to use the pagination functions?
     *
     * @var bool
     */
    private $hasPagination = false;



    /*
   |--------------------------------------------------------------------------
   | Resource settings and container
   |--------------------------------------------------------------------------
   |
   | Parameters concerning resources and which classes can handle resources
   |
   */

    /**
     * Class to treat as the resource handler
     *
     * @var string
     */
    private $resourceClass;

    /**
     * Collection of resource classes representing UnionCloud objects
     *
     * @var ResourceCollection
     */
    protected $resources;













    /*
   |--------------------------------------------------------------------------
   | Ready to parse a response
   |--------------------------------------------------------------------------
   |
   | Load up the details ready to parse a response
   |
   */

    /**
     * BaseResponse constructor.
     *
     * Saves the resource class to use, response, request and request options.
     * Also saves the response body
     *
     * @param Response $response Response from Guzzle
     * @param Request $request Request from Guzzle
     * @param array $requestOptions Guzzle HTTP Options
     * @param string $resourceClass Class that implements IResource
     *
     * @throws IncorrectResponseTypeException
     */
    public function __construct($response, $request, $requestOptions, $resourceClass)
    {
        if( ! $response instanceof Response)
        {
            throw new IncorrectResponseTypeException('Request class didn\'t pass a response type into the response', 500);
        }
        if( ! $request instanceof Request)
        {
            throw new IncorrectResponseTypeException('Request class didn\'t pass a request type into the response', 500);
        }

        $this->resourceClass = $resourceClass;
        $this->response = $response;
        $this->request = $request;
        $this->requestOptions = $requestOptions;
        $this->saveResponseBody();

    }

    /**
     * Saves the response body
     *
     * Split the response body into data and meta, and save it
     * as properties of this class
     *
     * @return void
     */
    private function saveResponseBody()
    {
        $body = $this->response->getBody()->getContents();
        if(is_string($body))
        {
            $body = json_decode($body, true);
        }
        $this->rawData = $body['data'];
        $this->rawMeta = $body['meta'];

    }





    /*
   |--------------------------------------------------------------------------
   | Parse a Response
   |--------------------------------------------------------------------------
   |
   | Execute the parsing of a response
   |
   */

    ########################### Controller ############################

    /**
     * Entry into instructing the Response to parse the data
     *
     * @return void
     */
    protected function parseResponse()
    {
        // Process MetaData
        $this->processMetadata();

        $this->throwIfErrors();

        $this->resources = $this->parseResources();
    }

    ########################### Parse the raw metadata ############################
    /**
     * Process the metadata and save it.
     */
    private function processMetadata()
    {
        $this->statusCode = (int) $this->response->getStatusCode();
        $this->responseDate = Carbon::parse($this->getHeaderFromResponse('Date'));
        $this->runTime = (double) $this->getHeaderFromResponse('X-Runtime');
        $this->xRequestID = $this->getHeaderFromResponse('X-Request-ID');

        if($this->responseContainsPagination())
        {
            $this->hasPagination = true;
            $this->recordsPerPage = (int) $this->getHeaderFromResponse('records_per_page');
            $this->totalPages = (int) $this->getHeaderFromResponse('total_pages');
        }

        $this->totalRecords = (int) $this->getRawMeta()['Total'];
        $this->failedRecords = (int) $this->getRawMeta()['Failure'];
        $this->successfulRecords = (int) $this->getRawMeta()['Success'];
    }

    /**
     * Gets a header from the Guzzle Response
     *
     * @param string $headerName
     *
     * @return mixed
     */
    private function getHeaderFromResponse($headerName)
    {
        return $this->response->getHeader($headerName)[0];
    }

    /**
     * Check if the response is able to use the pagination functions
     *
     * @return bool
     */
    public function responseContainsPagination()
    {
        if(
            array_key_exists('records_per_page', $this->response->getHeaders())
            &&
            array_key_exists('total_records', $this->response->getHeaders())
            &&
            array_key_exists('total_pages', $this->response->getHeaders())
        )
        {
            return true;
        }
        return false;
    }

    /**
     * Get the raw meta data (i.e. the Summary)
     *
     * @return mixed
     */
    public function getRawMeta()
    {
        return $this->rawMeta['Summary'];
    }

    /**
     * Throw errors if there were some from the response
     */
    private function throwIfErrors()
    {
        // Look through the API documentation to throw necessary errors.
    }

    /**
     * Interface to the resource.
     *
     * Will return a collection of all the resources populated with data
     *
     * @return ResourceCollection
     */
    private function parseResources()
    {
        $resources = new ResourceCollection();
        foreach($this->getRawData() as $resource)
        {
            $parsedResource = $this->parseResource($resource);
            $resources->addResource($parsedResource);
        }

        return $resources;
    }

    /**
     * Parse a single resource, given an array of parameters
     *
     * @param $resource
     *
     * @return mixed
     */
    private function parseResource($resource)
    {

        $resourceClass = new $this->resourceClass($resource);

        return $resourceClass;

    }














    /*
    |--------------------------------------------------------------------------
    | Get Details
    |--------------------------------------------------------------------------
    |
    | Execute the parsing of a response
    |
    */


    /**
     * Get the date returned by the server
     *
     * @return Carbon
     */
    public function getResponseDate()
    {
        return $this->responseDate;
    }

    /**
     * Get the time taken for the server to complete the task
     *
     * @return float
     */
    public function getRunTime()
    {
        return $this->runTime;
    }

    /**
     * Get the X-Request-ID from the response
     *
     * @return string
     */
    public function getXRequestID()
    {
        return $this->xRequestID;
    }

    /**
     * Get the Status Code of the request
     *
     * @return int
     */
    public function getStatusCode()
    {
        return $this->statusCode;
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
     * Get the request
     *
     * @return Request
     */
    public function getRawRequest()
    {
        return $this->request;
    }

    /**
     * Get the response
     *
     * @return Response
     */
    public function getRawResponse()
    {
        return $this->response;
    }

    /**
     * Get the request options passed to Guzzle HTTP
     *
     * @return array
     */
    public function getRequestOptions()
    {
        return $this->requestOptions;
    }

    /**
     * Get the total number of pages for a pagination request
     *
     * @return int
     */
    public function getTotalPages()
    {
        return $this->totalPages;
    }














    /*
    |--------------------------------------------------------------------------
    | Returning Resources
    |--------------------------------------------------------------------------
    |
    | Functions to return resources
    |
    */


    /**
     * Remove options if debug isn't on
     */
    public function removeDebugOptions()
    {
        unset($this->response);
        unset($this->request);
        unset($this->rawData);
        unset($this->rawMeta);
        unset($this->requestOptions);
    }

    /**
     * Get the returned resources
     *
     * @return ResourceCollection
     */
    public function get()
    {
        return $this->resources;
    }

}