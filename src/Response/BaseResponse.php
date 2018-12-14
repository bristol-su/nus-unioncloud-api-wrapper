<?php
/**
 * BaseResponse class
 */
namespace Twigger\UnionCloud\API\Response;

use Carbon\Carbon;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Twigger\UnionCloud\API\Exception\BaseUnionCloudException;
use Twigger\UnionCloud\API\Exception\Request\IncorrectRequestParameterException;
use Twigger\UnionCloud\API\Exception\Resource\ResourceNotFoundException;
use Twigger\UnionCloud\API\ResourceCollection;
use Twigger\UnionCloud\API\Exception\Response\IncorrectResponseTypeException;

/**
 * Handle processing a response and creating Resource classes out of the response
 *
 * Class BaseResponse
 *
 * @package Twigger\UnionCloud\API\Core\Responses
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
        if (!$response instanceof Response)
        {
            throw new IncorrectResponseTypeException('Request class didn\'t pass a response type into the response', 500);
        }
        if (!$request instanceof Request)
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
        if (is_string($body))
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

        // Unfortunately, UnionCloud often returns 200 when an error occured (such as the requested resource wasn't found)
        // We can look at the body of the response to extract any errors
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

        if ($this->responseContainsPagination())
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
        if (
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
     *
     * Guzzle catches any errors documented by the status code. Therefore,
     * the only place to look for errors is in the response body.
     *
     * Since all API calls may return different errors, the rules defined
     * below may not be universal. If you spot an error, creating a pull
     * request with a fix would be hugely appreciated!
     *
     * Similarly, not all errors may be documented. If you spot an error from
     * UnionCloud that slips through, a pull request would be awesome.
     *
     * @throws ResourceNotFoundException
     * @throws BaseUnionCloudException
     */
    private function throwIfErrors()
    {

        // If no data was returned, no resource was found
        if($this->getRawData() === null)
        {
            throw new ResourceNotFoundException('The resource wasn\'t found', 404);
        }

        $responseBody = (array_key_exists(0, $this->getRawData())?$this->getRawData()[0]:$this->getRawData());

        // Process the standard error code response.

        if(array_key_exists('errors', $responseBody) || array_key_exists('error', $responseBody))
        {
            $errors = [];
            // Get the errors
            if(array_key_exists('errors', $responseBody))
            {
                $errors = $responseBody['errors'];
            } elseif(array_key_exists('error', $responseBody))
            {
                $errors = $responseBody['error'];
            }

            // Standardize the errors. If the errors aren't in an enclosing array, put them in one so we can iterate through them
            if(! array_key_exists(0, $errors))
            {
                $errors = [$errors];
            }

            // Throw the error
            // TODO allow all errors to be seen by the user
            foreach($errors as $error)
            {
                if(array_key_exists('error_code', $error) && array_key_exists('error_message', $error))
                {
                    $this->throwCustomUnionCloudError($error);
                }
            }


            // Default throw if error_code or error_message is missing
            throw new BaseUnionCloudException('Couldn\'t parse the UnionCloud response: '.json_encode($this->getRawData()), 500);

        }
    }

    /**
     * Throws an error depending on the error returned from UnionCloud
     *
     * If the error code wasn't understood, throws a generic error with the
     * raw information from UnionCloud
     *
     * @param array $error single error from UnionCloud
     *
     * @throws BaseUnionCloudException
     */
    private function throwCustomUnionCloudError($error)
    {
        $errorCode = $error['error_code'];
        $errorMessage = $error['error_message'];
        if(($errorDetails = $this->getUnionCloudErrorDetails($errorCode)) !== false)
        {
            throw new $errorDetails['errorClass']($errorDetails['message'], $errorDetails['code'], null, $errorCode, $errorMessage);
        }


        throw new BaseUnionCloudException($error['error_message'], 500, null, $errorCode);
    }

    /**
     * Gets specific details about an error given the error code
     *
     * @param string $errorCode
     *
     * @return array|bool false if no error documented, or
     *      ['errorClass'=>'..Exception::class', 'code'=>'HTTP code', 'message' => 'Error Message'
     */
    private function getUnionCloudErrorDetails($errorCode)
    {
        $errors = [
            '401' => [
                IncorrectRequestParameterException::class,
                401,
                'Invalid Email or Password'
            ],
            '402' => [
                IncorrectRequestParameterException::class,
                401,
                'Invalid App ID or Password'
            ],
            '403' => [
                IncorrectRequestParameterException::class,
                401,
                'You need further API permissions'
            ],
            '404' => [
                IncorrectRequestParameterException::class,
                500,
                'Unknown error authenticating'
            ],
            '405' => [
                IncorrectRequestParameterException::class,
                401,
                'Authentication parameters missing'
            ],
            '413' => [
                IncorrectRequestParameterException::class,
                429,
                'Too many requests'
            ],
            'ERR101' => [
                IncorrectRequestParameterException::class,
                400,
                'Something went wrong with your email'
            ],
            'ERR102' => [
                IncorrectRequestParameterException::class,
                400,
                'Something went wrong with your forename'
            ],
            'ERR103' => [
                IncorrectRequestParameterException::class,
                400,
                'Something went wrong with your surname'
            ],
            'ERR104' => [
                IncorrectRequestParameterException::class,
                400,
                'Something went wrong with your DoB'
            ],
            'ERR105' => [
                IncorrectRequestParameterException::class,
                400,
                'Something went wrong with your gender'
            ],
            'ERR106' => [
                IncorrectRequestParameterException::class,
                400,
                'Something went wrong with your additional identities'
            ],
            'ERR107' => [
                IncorrectRequestParameterException::class,
                400,
                'Something went wrong with your institution email'
            ],
            'ERR108' => [
                IncorrectRequestParameterException::class,
                400,
                'Something went wrong with your student ID'
            ],
            'ERR109' => [
                IncorrectRequestParameterException::class,
                400,
                'Something went wrong with your nationality'
            ],
            'ERR110' => [
                IncorrectRequestParameterException::class,
                400,
                'Something went wrong with your Domicile Country'
            ],
            'ERR111' => [
                IncorrectRequestParameterException::class,
                400,
                'Something went wrong with your fee status'
            ],
            'ERR112' => [
                IncorrectRequestParameterException::class,
                400,
                'Something went wrong with your study type'
            ],
            'ERR113' => [
                IncorrectRequestParameterException::class,
                400,
                'Something went wrong with your programme level'
            ],
            'ERR114' => [
                IncorrectRequestParameterException::class,
                400,
                'Something went wrong with your course end date'
            ],
            'ERR115' => [
                IncorrectRequestParameterException::class,
                400,
                'Something went wrong with your alternate email address'
            ],
            'ERR116' => [
                IncorrectRequestParameterException::class,
                400,
                'Something went wrong with your library card'
            ],
            'ERR117' => [
                IncorrectRequestParameterException::class,
                400,
                'Something went wrong with your erasmus status'
            ],
            'ERR118' => [
                IncorrectRequestParameterException::class,
                400,
                'Something went wrong with your finalist status'
            ],
            'ERR119' => [
                IncorrectRequestParameterException::class,
                400,
                'Something went wrong with your mode of study'
            ],
            'ERR120' => [
                IncorrectRequestParameterException::class,
                400,
                'Something went wrong with your placement status'
            ],
            'ERR121' => [
                IncorrectRequestParameterException::class,
                400,
                'Something went wrong with your record type'
            ],
            'ERR122' => [
                IncorrectRequestParameterException::class,
                404,
                'No user found'
            ],
            'ERR123' => [
                IncorrectRequestParameterException::class,
                400,
                'Something went wrong with your NUS communication status'
            ],
            'ERR124' => [
                IncorrectRequestParameterException::class,
                400,
                'Something went wrong with your NUS commercial communication status'
            ],
            'ERR125' => [
                IncorrectRequestParameterException::class,
                400,
                'Something went wrong with your union communication status'
            ],
            'ERR126' => [
                IncorrectRequestParameterException::class,
                400,
                'Something went wrong with your union commercial communication status'
            ],
            'ERR127' => [
                IncorrectRequestParameterException::class,
                400,
                'Something went wrong with your terms and conditions'
            ],
            'ERR201' => [
                ResourceNotFoundException::class,
                404,
                'Group ID wasn\'t found'
            ],
            'ERR203' => [
                IncorrectRequestParameterException::class,
                404,
                'Membership type ID not found or approved'
            ],
            'ERR205' => [
                IncorrectRequestParameterException::class,
                400,
                'Next of Kin forename can\'t be blank'
            ],
            'ERR206' => [
                IncorrectRequestParameterException::class,
                400,
                'Next of Kin surname can\'t be blank'
            ],
            'ERR207' => [
                IncorrectRequestParameterException::class,
                400,
                'Next of Kin relationship can\'t be blank'
            ],
            'ERR208' => [
                IncorrectRequestParameterException::class,
                400,
                'Next of Kin address can\'t be blank'
            ],
            'ERR209' => [
                IncorrectRequestParameterException::class,
                400,
                'Next of Kin home phone can\'t be blank'
            ],
            'ERR212' => [
                IncorrectRequestParameterException::class,
                400,
                'You need to be over 18 to join this group'
            ],
            'ERR213' => [
                IncorrectRequestParameterException::class,
                400,
                'Please answer all mandatory questions'
            ],
            'ERR301' => [
                IncorrectRequestParameterException::class,
                400,
                'Something went wrong with the UserGroup name'
            ],
            'ERR302' => [
                ResourceNotFoundException::class,
                400,
                'Folder can\'t be found'
            ],
            'ERR304' => [
                ResourceNotFoundException::class,
                404,
                'UserGroup can\'t be found'
            ],
            'ERR305' => [
                IncorrectRequestParameterException::class,
                400,
                'Unable to delete - contains a reference to another resource'
            ],
            'ERR306' => [
                IncorrectRequestParameterException::class,
                400,
                'Unable to delete - system generated UserGroup'
            ],
            'ERR307' => [
                IncorrectRequestParameterException::class,
                400,
                'Unable to delete - folder not empty'
            ],
            'ERR308' => [
                IncorrectRequestParameterException::class,
                400,
                'Expiry date is required'
            ],
            'ERR309' => [
                IncorrectRequestParameterException::class,
                400,
                'UID is required'
            ],
            'ERR310' => [
                IncorrectRequestParameterException::class,
                404,
                'UserGroup not found'
            ],
            'ERR311' => [
                IncorrectRequestParameterException::class,
                400,
                'Cannot modify this UserGroups UserGroup Memberships'
            ],
            'ERR312' => [
                IncorrectRequestParameterException::class,
                400,
                'UserGroup Membership already exists'
            ],
            'ERR313' => [
                IncorrectRequestParameterException::class,
                404,
                'UserGroup Membership ID not found'
            ],
            'ERR501' => [
                IncorrectRequestParameterException::class,
                400,
                'Event name cannot be more than 255 characters'
            ],
            'ERR502' => [
                IncorrectRequestParameterException::class,
                400,
                'Event Type ID is mandatory'
            ],
            'ERR503' => [
                IncorrectRequestParameterException::class,
                400,
                'Start date not valid'
            ],
            'ERR504' => [
                IncorrectRequestParameterException::class,
                400,
                'End date not valid'
            ],
            'ERR505' => [
                IncorrectRequestParameterException::class,
                400,
                'Description is required, and can\'t be longer than 8000 characters'
            ],
            'ERR506' => [
                IncorrectRequestParameterException::class,
                400,
                'Event name is mandatory'
            ],
            'ERR507' => [
                IncorrectRequestParameterException::class,
                400,
                'Contact details are mandatory'
            ],
            'ERR508' => [
                IncorrectRequestParameterException::class,
                400,
                'The capaciy is incorrect'
            ],
            'ERR511' => [
                IncorrectRequestParameterException::class,
                400,
                'Published date should be in the future'
            ],
        ];

        if(array_key_exists($errorCode, $errors))
        {
            $error = $errors[$errorCode];
            return [
                'errorClass' => $error[0],
                'code' => $error[1],
                'message' => $error[2]
            ];
        }

        return false;
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
        // TODO This will throw an error if data wasn't returned in an array

        try {
            foreach ($this->getRawData() as $resource) {
                $parsedResource = $this->parseResource($resource);
                $resources->addResource($parsedResource);
            }
        } catch(\Exception $e) { }
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