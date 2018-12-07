<?php

namespace Twigger\UnionCloud\Request;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;
use Twigger\UnionCloud\Auth\Authentication;
use Twigger\UnionCloud\Configuration;
use Twigger\UnionCloud\Exception\Response\AuthRefreshRequiredException;
use Twigger\UnionCloud\Exception\Response\BaseResponseException;
use Twigger\UnionCloud\Response\BaseResponse;

/**
 * Contains helper functions relevant to making a request
 *
 * @package    UnionCloud
 * @license    https://opensource.org/licenses/GPL-3.0  GNU Public License v3
 * @author     Toby Twigger <tt15951@bristol.ac.uk>
 */
class BaseRequest
{

    /**
     * @var Authentication
     */
    protected $authentication;

    /**
     * @var Configuration
     */
    protected $configuration;

    /**
     * @var array
     */
    private $body;
    private $method;
    private $contentType;
    private $endPoint;
    private $queryParameters;
    private $responseClass;
    private $response;
    private $request;

    public function __construct($authentication, $configuration)
    {
        $this->authentication = $authentication;
        $this->configuration = $configuration;
    }

    /**
     * Handle creating the API request and receiving the response.
     */
    protected function call()
    {
        // Build up Guzzle HTTP Options, including authentication
        $options = $this->authentication->addAuthentication($this->getDefaultGuzzleOptions(), $this->configuration);
        $client = new Client([
            'base_uri' => $this->configuration->getBaseURL()
        ]);
        try{
            $request = new Request(
                $this->getMethod(),
                $this->getFullURL()
            );
            $response = $client->send($request, $options);
        } catch (RequestException $e)
        {
            // Check for refresh authentication
            try{
                $this->throwAdditionalExceptions($e);
            } catch(AuthRefreshRequiredException $authE)
            {
                // TODO Refresh authentication
                throw $authE;
            }
            throw $e;
        }

        $this->request = $request;
        $this->response = $response;
    }

    private function getFullURL()
    {
        $url = $this->configuration->getBaseURL().'/api/'.$this->getEndPoint();
        if($this->getQueryParameters())
        {
            $url .= '?'.http_build_query($this->getQueryParameters());
        }
        return $url;
    }

    /**
     * @param RequestException $e
     * @throws AuthRefreshRequiredException
     */
    private function throwAdditionalExceptions(RequestException $e)
    {
        if($e->getCode() === 401)
        {
            throw new AuthRefreshRequiredException();
        }
    }

    private function getDefaultGuzzleOptions()
    {
        $options = [
            'headers' => [
                "User-Agent" => "Twigger-UnionCloud-API-Wrapper",
                "Content-Type" => $this->getContentType(),
                //"Accept-Version" => "v1",
                //"Accept" => 'application/json'
            ],
            'http_errors' => true,
            'verify' => __DIR__ . '/../../unioncloud.pem',
            'debug' => false
        ];
        if($this->getContentType() === 'multipart/form-data')
        {
            $options['multipart'] = $this->getBody();
        } elseif ($this->getContentType() === 'application/json' && $this->getBody()) {
            $options["body"] = json_encode($this->getBody(), true);
        }

        return $options;
    }

    public function setMode($mode)
    {
        $this->queryParameters['mode'] = $mode;

        return $this;
    }

    private function getEndPoint()
    {
        return $this->endPoint;
    }

    private function getQueryParameters()
    {
        return $this->queryParameters;
    }

    private function getBody()
    {
        return $this->body;
    }

    public function setBody($body)
    {
        $this->body = $body;
    }

    public function setEndpoint($endPoint)
    {
        $this->endPoint = $endPoint;
    }

    private function getMethod()
    {
        return $this->method;
    }

    public function setMethod($method)
    {
        $this->method = $method;
    }

    private function getContentType()
    {
        if(!$this->contentType)
        {
            if($this->getMethod() === 'POST') { return 'multipart/form-data'; }
            else { return 'application/json'; }
        }
        return $this->contentType;
    }

    public function setContentType($contentType)
    {
        if($contentType === 'json') { $contentType = 'application/json'; }
        elseif($contentType === 'form') { $contentType = 'multipart/form-data'; }
        $this->contentType = $contentType;
    }

    public function setResponseClass($responseClass)
    {
        $this->responseClass = $responseClass;
    }

    /**
     * @param $response
     *
     * @param string $responseHandler
     *
     * @return BaseResponse
     */
    public function processResponse($responseHandler)
    {

        var_dump($responseHandler);
        if( ! is_subclass_of($responseHandler, BaseResponse::class))
        {
            throw new BaseResponseException('The response handler must extend BaseResponse', 500);
        }

        $processedResponse = new $responseHandler($this->response, $this->request);

        return $processedResponse;
    }

    protected function setAPIParameters(
        $endpoint,
        $method,
        $responseClass
        )
    {
        $this->setEndpoint($endpoint);
        $this->setMethod($method);
        $this->setResponseClass($responseClass);
    }
}