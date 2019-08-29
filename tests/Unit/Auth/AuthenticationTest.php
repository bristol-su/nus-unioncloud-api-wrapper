<?php

namespace Twigger\UnionCloud\Tests\Unit\Auth;

use Prophecy\Argument;
use Twigger\UnionCloud\API\Auth\Authentication;
use Twigger\UnionCloud\API\Auth\IAuthenticator;
use Twigger\UnionCloud\API\Configuration;
use Twigger\UnionCloud\API\Exception\Authentication\AuthenticationParameterMissing;
use Twigger\UnionCloud\API\Exception\Authentication\AuthenticatorMustExtendIAuthenticator;
use Twigger\UnionCloud\API\Exception\Authentication\AuthenticatorNotFound;
use Twigger\UnionCloud\Tests\TestCase;

class AuthenticationTest extends TestCase
{

    /** @test */
    public function it_validates_and_sets_the_authentication_parameters_on_construction(){
        $authenticator = $this->prophesize(IAuthenticator::class);
        $authArray = ['foo' => 'bar'];
        $authenticator->validateParameters($authArray)->shouldBeCalled()->willReturn(true);
        $authenticator->setParameters($authArray)->shouldBeCalled();

        $authentication = new Authentication($authArray, $authenticator->reveal());
    }

    /** @test */
    public function it_throws_an_error_if_authentication_parameters_missing(){
        $authenticator = $this->prophesize(IAuthenticator::class);
        $authArray = ['foo' => 'bar'];
        $authenticator->validateParameters($authArray)->shouldBeCalled()->willReturn(false);

        $this->expectException(AuthenticationParameterMissing::class);

        new Authentication($authArray, $authenticator->reveal());
    }

    /** @test */
    public function it_throws_an_error_if_authenticator_not_null_or_not_instanceof_interface(){
        $authenticator = 'IncorrectParameter';
        $authArray = ['foo' => 'bar'];

        $this->expectException(AuthenticatorNotFound::class);

        new Authentication($authArray, $authenticator);
    }

    /** @test */
    public function it_throws_an_error_when_manually_setting_authenticator_if_not_instanceof_iauthenticator(){
        $authentication = new Authentication;

        $this->expectException(AuthenticatorMustExtendIAuthenticator::class);

        $authentication->setAuthenticator('incorrect');

    }


    /** @test */
    public function it_gets_a_transformed_authentication_array(){
        $authenticator = $this->prophesize(IAuthenticator::class);
        $configuration = $this->prophesize(Configuration::class);
        $options = ['foo' => 'bar'];


        $authenticator->needsRefresh()->shouldBeCalled()->willReturn(false);
        $authenticator->addAuthentication($options)->shouldBeCalled();

        $authentication = new Authentication;
        $authentication->setAuthenticator($authenticator->reveal());

        $authentication->addAuthentication($options, $configuration->reveal());
    }

    /** @test */
    public function it_refreshes_authentication_if_necessary(){
        $authenticator = $this->prophesize(IAuthenticator::class);
        $configuration = $this->prophesize(Configuration::class);
        $configuration->getBaseURL()->shouldBeCalled()->willReturn('baseUrl');
        $options = ['foo' => 'bar'];


        $authenticator->needsRefresh()->shouldBeCalled()->willReturn(true);
        $authenticator->authenticate('baseUrl')->shouldBeCalled();
        $authenticator->addAuthentication($options)->shouldBeCalled();

        $authentication = new Authentication;
        $authentication->setAuthenticator($authenticator->reveal());

        $authentication->addAuthentication($options, $configuration->reveal());
    }

    /** @test */
    public function it_returns_true_if_it_has_an_authenticator(){
        $authentication = new Authentication;
        $authenticator = $this->prophesize(IAuthenticator::class);

        $authentication->setAuthenticator($authenticator->reveal());

        $this->assertTrue($authentication->hasAuthentication());
    }

    /** @test */
    public function it_returns_false_if_it_does_not_have_an_authenticator(){
        $authentication = new Authentication;
        $this->assertFalse($authentication->hasAuthentication());
    }

}