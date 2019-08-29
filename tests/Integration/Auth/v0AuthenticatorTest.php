<?php


namespace Twigger\UnionCloud\Tests\Integration\Auth;

use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Request;
use Twigger\UnionCloud\API\Auth\v0Authenticator;
use Twigger\UnionCloud\API\Exception\Authentication\BaseUnionCloudAuthenticationException;
use Twigger\UnionCloud\API\Exception\BaseUnionCloudException;
use Twigger\UnionCloud\Tests\TestCase;

class v0AuthenticatorTest extends TestCase
{

    /** @test */
    public function it_validates_a_set_of_correct_parameters()
    {
        $authenticator = new v0Authenticator();

        $this->assertTrue(
            $authenticator->validateParameters([
                'email' => 'email',
                'password' => 'password',
                'appID' => 'app Id',
                'appPassword' => 'app Password'
            ])
        );
    }

    /** @test */
    public function it_requires_an_email()
    {
        $authenticator = new v0Authenticator;

        $this->assertFalse(
            $authenticator->validateParameters([
                'password' => 'password',
                'appId' => 'appId',
                'appPassword' => 'appPassword'
            ])
        );
    }

    /** @test */
    public function it_requires_a_password()
    {
        $authenticator = new v0Authenticator;

        $this->assertFalse(
            $authenticator->validateParameters([
                'email' => 'email',
                'appId' => 'appId',
                'appPassword' => 'appPassword'
            ])
        );
    }

    /** @test */
    public function it_requires_an_app_id()
    {
        $authenticator = new v0Authenticator;

        $this->assertFalse(
            $authenticator->validateParameters([
                'email' => 'email',
                'password' => 'password',
                'appPassword' => 'appPassword'
            ])
        );
    }

    /** @test */
    public function it_requires_an_app_password()
    {
        $authenticator = new v0Authenticator;

        $this->assertFalse(
            $authenticator->validateParameters([
                'email' => 'email',
                'password' => 'password',
                'appId' => 'appId',
            ])
        );
    }

    /** @test */
    public function it_throws_an_error_if_guzzle_throws_an_error()
    {
        $mockHandler = new MockHandler([
            new RequestException('Unauthenticated', new Request('POST', '/api/authenticate'))
        ]);

        $handler = HandlerStack::create($mockHandler);

        $authenticator = new v0Authenticator;

        $this->expectException(BaseUnionCloudException::class);
        $authenticator->authenticate('baseurl', ['handler' => $handler]);
    }

    /** @test */
    public function it_adds_the_auth_token_to_the_header_options(){
        $options = ['headers' => []];

        $authenticator = new v0Authenticator();

        $returnedOptions = $authenticator->addAuthentication($options);

        $this->assertArrayHasKey('auth_token', $returnedOptions['headers']);

    }
}