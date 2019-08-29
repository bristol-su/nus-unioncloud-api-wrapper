<?php

namespace Twigger\UnionCloud\Tests\Unit;

use GuzzleHttp\Psr7\Response;
use Twigger\UnionCloud\API\Auth\Authentication;
use Twigger\UnionCloud\API\Configuration;
use Twigger\UnionCloud\API\Request\BaseRequest;
use Twigger\UnionCloud\API\Response\BaseResponse;
use Twigger\UnionCloud\Tests\TestCase;

class BaseRequestTest extends TestCase
{

    /** @var Authentication */
    private $authentication;

    /** @var Configuration */
    private $configuration;

    /** @var BaseResponse*/
    private $response;

    /** @var BaseRequest */
    private $request;

    public function setUp()
    {
        parent::setUp();

        $this->authentication = $this->prophesize(Authentication::class);
        $this->configuration = $this->prophesize(Configuration::class);
        $this->response = $this->prophesize(BaseResponse::class);
        $this->request = new BaseRequest($this->authentication, $this->configuration, $this->response);
    }



}