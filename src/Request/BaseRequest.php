<?php
/**
 * BaseRequest Class, provides ability to create API calls
 */
namespace Twigger\UnionCloud\API\Request;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Twigger\UnionCloud\API\Auth\Authentication;
use Twigger\UnionCloud\API\Configuration;
use Twigger\UnionCloud\API\Exception\Pagination\PageNotFoundException;
use Twigger\UnionCloud\API\Exception\Request\IncorrectRequestParameterException;
use Twigger\UnionCloud\API\Exception\Request\RequestHistoryNotFound;
use Twigger\UnionCloud\API\Exception\Response\BaseResponseException;
use Twigger\UnionCloud\API\Exception\Response\ResponseMustInheritIResponse;
use Twigger\UnionCloud\API\ResourceCollection;
use Twigger\UnionCloud\API\Response\BaseResponse;
use Twigger\UnionCloud\API\Response\IResponse;

/**
 * Contains helper functions relevant to making a request
 *
 * @package Twigger\UnionCloud\API\Core\Requests
 * @license    https://opensource.org/licenses/GPL-3.0  GNU Public License v3
 * @author     Toby Twigger <tt15951@bristol.ac.uk>
 */

class BaseRequest
{

    /**
     * Authentication wrapper
     *
     * @var Authentication
     */
    protected $authentication;

    /**
     * Configuration wrapper
     *
     * @var Configuration
     */
    protected $configuration;

    /**
     * A response class that implements IResponse
     *
     * @var BaseResponse
     */
    private $responseClass;

    /*
   |--------------------------------------------------------------------------
   | API parameters
   |--------------------------------------------------------------------------
   |
   | API Parameters to directly make up the API endpoint request
   |
   */

    /**
     * Body of the request
     *
     * @var array
     */
    private $body;

    /**
     * Method to use for the API request
     *
     * POST, GET etc.
     *
     * @var string
     */
    private $method;

    /**
     * Content Type of the request
     *
     * This is either
     *      -application\json if the body is a string
     *      -x-www-form-encoded if the body is an array
     * @var string
     */
    private $contentType;

    /**
     * Endpoint to send the API request to
     *
     * Relevant to '/api/'
     *
     * @var string
     */
    private $endPoint;

    /**
     * Query parameters to enter at the end of the URL
     *
     * @var array
     */
    private $queryParameters = [];

    /**
     * If this is true, the 'mode' query parameter will be set
     *
     * @var bool
     */
    private $useMode = false;

    /**
     * Mode to use for the request.
     *
     * @var string $mode basic|standard|full
     */
    private $mode = 'full';

    /**
     * Should pagination be used?
     *
     * This will be set by the Request Class, i,e, by the developer
     *
     * @var bool $paginates
     */
    private $paginates = false;

    /**
     * Page to use.
     *
     * This will be put into the query parameters if $pagination is true
     *
     * @var int $page
     */
    private $page = 1;













    /*
   |--------------------------------------------------------------------------
   | Parameters to pass to Response
   |--------------------------------------------------------------------------
   |
   | These parameters are set so they can be passed to
   | the response class
   |
   */

    /**
     * Response captured from Guzzle for debugging
     *
     * @var Response
     */
    private $debugResponse;

    /**
     * Request captured from Guzzle for debugging
     * @var Request
     */
    private $debugRequest;

    /**
     * Request options passed into Guzzle, for debugging
     * @var array
     */
    private $requestOptions;

    /**
     * Container for the Guzzle HTTP Stack
     *
     * @var array
     */
    private $container = [];










    /*
    |--------------------------------------------------------------------------
    | Response Parameters
    |--------------------------------------------------------------------------
    |
    | Parameters to control the response information
    |
    */

    /**
     * Determines what calling a request action (i.e. search()) will return
     *
     * If set to false, as is by default, the response class alone will be returned
     * If set to true, the whole request class will be passed back. This allows the
     * user to access the pagination methods
     * @var bool
     */
    private $returnRequestClass = false;

    /**
     * Response from UnionCloud
     *
     * This is populated by the $this->call() function
     *
     * @var BaseResponse
     */
    private $response;











    /*
    |--------------------------------------------------------------------------
    | Construct && class-wide helpers
    |--------------------------------------------------------------------------
    |
    | Save necessary configurations from the UnionCloud Wrapper. A
    |
    */

    /**
     * BaseRequest constructor.
     *
     * Saves the given authenticator and configuration
     *
     * @param Authentication $authentication
     * @param Configuration $configuration
     * @param string $responseClass
     */
    public function __construct($authentication, $configuration, $responseClass)
    {
        $this->authentication = $authentication;
        $this->configuration = $configuration;
        $this->setResponseClass($responseClass);
    }

    /**
     * Returns an instance of the child class, or of itself if
     * the child class hasn't implemented the getInstance method
     *
     * @return BaseRequest
     */
    private function getChildInstance()
    {
        if (method_exists($this, 'getInstance'))
        {
            return $this->getInstance();
        }
        return $this;
    }




    /*
   |--------------------------------------------------------------------------
   | User options for APIs
   |--------------------------------------------------------------------------
   |
   | These can be used by the end user to alter default options when creating
   | API calls.
   |
   */


    /**
     * Allow the user to set the mode of the API
     *
     * @param $mode
     *
     * @return $this
     */
    public function setMode($mode)
    {
        $this->mode = $mode;
        return $this;
    }


    /**
     * Enable pagination from the user side.
     *
     * Will tell the UnionCloud request that the
     * request class should be returned, as opposed to the response class
     *
     * @return $this UserRequest class
     */
    public function paginate()
    {
        $this->returnRequestClass = true;
        return $this->getChildInstance();
    }

    /**
     * Set the page number
     *
     * @param $page
     * @throws IncorrectRequestParameterException
     *
     * @return $this
     */
    public function setPage($page)
    {
        if (!is_int($page))
        {
            throw new IncorrectRequestParameterException('Page must be an integer', 400);
        }
        $this->page = $page;

        return $this->getChildInstance();
    }






    /*
   |--------------------------------------------------------------------------
   | API Endpoint Construction
   |--------------------------------------------------------------------------
   |
   | To make it easy to construct API Endpoints, a supply of helper functions
   | have been created.
   |
   */

    /**
     * Allows the API endpoint to support pagination
     *
     * Call this when defining an API endpoint.
     *
     * @return void
     */
    protected function enablePagination()
    {
        $this->paginates = true;
        // TODO Enable supoport for number of records per page
    }

    /**
     * Allow an API to use the ?mode= query
     *
     * @param string $mode
     */
    protected function enableMode()
    {
        $this->useMode = true;
    }

    /**
     * Allow an API to use the updated_at_before and updated_at_after parameters
     */
    protected function enableTimes()
    {
        // TODO Implement the enableTimes method
    }

    /**
     * Set the body as an array
     *
     * @param $body
     */
    protected function setBody($body)
    {
        $this->body = $body;
    }

    /**
     * Set the endpoint for the API request
     *
     * @param string $endPoint
     */
    protected function setEndpoint($endPoint)
    {
        $this->endPoint = $endPoint;
    }

    /**
     * Set the method for the API
     *
     * @param $method
     */
    protected function setMethod($method)
    {
        $this->method = $method;
    }

    /**
     * Set the content type
     *
     * You may pass in full content types, or use the shortcuts
     *      'json' => 'application/json',
     *      'form' => 'application//x-www-form-urlencoded'
     *
     * @param $contentType
     */
    protected function setContentType($contentType)
    {
        if ($contentType === 'json') { $contentType = 'application/json'; }
        elseif ($contentType === 'form') { $contentType = 'application/x-www-form-urlencoded'; }
        $this->contentType = $contentType;
    }

    /**
     * Set the class to handle the response
     *
     * This must implement IResponse
     *
     * @param $responseClass
     */
    protected function setResponseClass($responseClass)
    {
        $this->responseClass = $responseClass;
    }

    /**
     * A shortcut method for setting all required parameters in one function call
     *
     * @param string $endpoint e.g. 'users/search'
     * @param string $method
     * @param array|null $body If you don't include it in a data array, we will
     */
    protected function setAPIParameters($endpoint,$method,$body=null)
    {
        $this->setEndpoint($endpoint);
        $this->setMethod($method);
        if($body !== null)
        {
            $this->setBody((array_key_exists('data', $body)?$body:array('data'=>$body)));
        }
    }

    /**
     * Adds a query parameter to the URL of the request
     *
     * @param string $key Key of the query parameter
     * @param string $value Value of the query parameter
     */
    protected function addQueryParameter($key, $value)
    {
        $this->queryParameters[$key] = $value;
    }

















    /*
    |--------------------------------------------------------------------------
    | Making API Calls
    |--------------------------------------------------------------------------
    |
    | A set of functions used in the creation of an API call
    |
    */

    ###################   Making the request    #######################

    /**
     * Handles making an API call
     *
     * Set all the parameters before calling this function.
     *
     * It will simply populate the property $this->response with the
     * response from UnionCloud
     *
     * @throws BaseResponseException
     * @throws RequestHistoryNotFound
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function call()
    {
        // TODO throw error if user requested pagination but it isn't activated

        // Build up Guzzle HTTP Options, including authentication
        $options = $this->authentication->addAuthentication($this->getDefaultGuzzleOptions(), $this->configuration);

        // Create a client
        $client = $this->createClient();

        try {
            $request = new Request(
                $this->getMethod(),
                $this->getFullURL()
            );
            $client->send($request, $options);
        } catch (\Exception $e)
        {
            // TODO extract any errors from the response itself
            throw new BaseResponseException('Something went wrong', 500, $e);
        }

        // Extract the history
        if (!array_key_exists(0, $this->container))
        {
            throw new RequestHistoryNotFound('Request History wasn\'t recorded', 500);
        }
        try {
            $this->debugRequest = $this->container[0]['request'];
            $this->debugResponse = $this->container[0]['response'];
            $this->requestOptions = $this->container[0]['options'];
        } catch (\Exception $e) {
            throw new RequestHistoryNotFound('The element wasn\'t found in the history array', 500, $e);
        }

        // TODO Ensure this method doesn't use the debug variables. That way these don't have to be recorded if not debugging
        $this->processResponse($this->responseClass);
    }


    ###################    Creating the Guzzle Options    #######################

    /**
     * Gets the default GuzzleHTTP array
     *
     * @return array
     */
    private function getDefaultGuzzleOptions()
    {
        $options = [
            'headers' => [
                "User-Agent" => "Twigger-UnionCloud-API-Wrapper",
                "Content-Type" => $this->getContentType(),
            ],
            'http_errors' => true,
            'verify' => __DIR__.'/../../unioncloud.pem',
            'debug' => false
        ];
        if ($this->getContentType() === 'application/x-www-form-urlencoded')
        {
            $options['form_params'] = $this->getBody();
        } elseif ($this->getContentType() === 'application/json' && $this->getBody()) {
            $options["body"] = json_encode($this->getBody());
        }

        return $options;
    }

    /**
     * Get the body to put into the request
     *
     * @return array
     */
    private function getBody()
    {
        return $this->body;
    }

    /**
     * Get the content type
     *
     * Will return application\x-www-form-urlencoded if a POST request is made, or
     * application/json otherwise.
     *
     * Can be overridden by using the $this->setContentType function
     *
     * @return string
     */
    private function getContentType()
    {
        if (!$this->contentType)
        {
            if ($this->getMethod() === 'POST') { return 'application/x-www-form-urlencoded'; }
            else { return 'application/json'; }
        }
        return $this->contentType;
    }


    ###################    Create a Client    #######################

    /**
     * Creates a client
     *
     * Creates a default client with the user specified Base URL.
     *
     * Will also implement history middleware if debug is on
     *
     * @return Client
     */
    private function createClient()
    {
        $history = Middleware::history($this->container);
        $stack = HandlerStack::create();
        $stack->push($history);


        $client = new Client([
            'base_uri' => $this->configuration->getBaseURL(),
            'handler' => $stack,
        ]);

        return $client;
    }


    ###################    Create the API request    #######################

    /**
     * Gets the method for the request
     *
     * @return string
     */
    private function getMethod()
    {
        return $this->method;
    }

    /**
     * Get the full URL
     *
     * This consists of:
     *      /api/endpoint?query
     *
     * @return string
     */
    private function getFullURL()
    {
        $url = '/api/'.$this->getEndPoint();
        if (($parameters = $this->getQueryParameters()) !== null)
        {
            $url .= '?'.http_build_query($parameters);
        }
        return $url;
    }

    /**
     * Get the endpoint for the API
     *
     * @return string
     */
    private function getEndPoint()
    {
        return $this->endPoint;
    }

    /**
     * Get the query parameters for the API URL
     *
     * @return array|null
     */
    private function getQueryParameters()
    {
        $queryParameters = $this->queryParameters;

        // Add parameters set through settings
        if ($this->paginates)
        {
            $queryParameters['page'] = $this->page;
        }
        if ($this->useMode)
        {
            $queryParameters['mode'] = $this->mode;
        }
        if (count($queryParameters) === 0)
        {
            return null;
        }

        return $queryParameters;
    }












    /*
    |--------------------------------------------------------------------------
    | Pagination
    |--------------------------------------------------------------------------
    |
    | A set of functions to enable pagination between results
    |
    */


    /**
     * Add one to the page
     *
     * @return $this
     */
    protected function addPage()
    {
        $this->page++;

        return $this->getChildInstance();
    }

    /**
     * Take one from the page
     *
     * @return $this
     */
    protected function minusPage()
    {
        $this->page--;

        return $this->getChildInstance();
    }

    /**
     * Return the BaseRequest populated with the next page in the pagination.
     *
     * @return $this
     *
     * @throws BaseResponseException
     * @throws PageNotFoundException
     * @throws RequestHistoryNotFound
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function next()
    {
        if (!$this->response instanceof IResponse || $this->page >= $this->response->getTotalPages())
        {
            throw new PageNotFoundException();
        }
        $this->addPage();
        $this->call();
        return $this->getChildInstance();
    }

    /**
     * Return the BaseRequest populated with the previous page in the pagination.
     *
     * @return BaseRequest
     *
     * @throws BaseResponseException
     * @throws PageNotFoundException
     * @throws RequestHistoryNotFound
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function previous()
    {
        if (!$this->response instanceof IResponse || $this->page <= 1) {
            throw new PageNotFoundException();
        }
        $this->minusPage();
        $this->call();
        return $this->getChildInstance();
    }

    /**
     * Get all records in the API.
     *
     * If you have many records, this API may take a long time. We suggest
     * implementing a timeout, or checking there aren't too many rectords
     *
     * @return ResourceCollection
     *
     * @throws BaseResponseException
     * @throws RequestHistoryNotFound
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getAllPages()
    {
        $resourceCollection = new ResourceCollection();
        $resourceCollection->addResources($this->response->get()->toArray());
        $this->addPage();
        while ($this->page <= $this->response->getTotalPages())
        {
            $this->call();
            $resourceCollection->addResources($this->response->get()->toArray());
            $this->addPage();
        }
        return $resourceCollection;
    }











    /*
    |--------------------------------------------------------------------------
    | Processing the Response
    |--------------------------------------------------------------------------
    |
    | A few functions to help process the response after an API call
    |
    */


    /**
     * Populate the $response property of the request
     *
     * Calls the construct of the chosen response handler,
     *
     * @param BaseResponse
     *
     * @throws BaseResponseException
     */
    private function processResponse($responseHandler)
    {
        if (!is_subclass_of($responseHandler, BaseResponse::class)) {
            throw new BaseResponseException('The response handler must extend BaseResponse', 500);
        }


        $processedResponse = new $responseHandler(
            $this->debugResponse,
            $this->debugRequest,
            $this->requestOptions
        );

        $this->response = $processedResponse;
    }











    /*
    |--------------------------------------------------------------------------
    | Returning the Response
    |--------------------------------------------------------------------------
    |
    | A few functions to help the user get what they need
    |
    */

    /**
     * Determine what to return to the user
     *
     * Return the request, a debugged response or a normal response
     *
     * @return $this|BaseResponse
     */
    protected function getReturnDetails()
    {
        if ($this->returnRequestClass)
        {
            $this->container = [];
            return $this;
        } else {
            if (!$this->configuration->getDebug())
            {
                $this->response->removeDebugOptions();
            }
            return $this->response;
        }
    }

    /**
     * Return just the collection of resources
     *
     * @return ResourceCollection\
     *
     * @throws ResponseMustInheritIResponse
     */
    public function get()
    {
        return $this->getResponse()->get();
    }

    /**
     * Get the whole response class
     *
     * @return BaseResponse|IResponse
     *
     * @throws ResponseMustInheritIResponse
     */
    public function getResponse()
    {
        if (!$this->response instanceof IResponse)
        {
            throw new ResponseMustInheritIResponse();
        }
        return $this->response;
    }


}