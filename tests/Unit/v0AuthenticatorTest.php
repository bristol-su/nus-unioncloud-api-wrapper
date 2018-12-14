<?php
/**
 * v0Authenticator Test
 */
namespace Twigger\UnionCloud\Tests;

use Twigger\UnionCloud\API\Auth\v0Authenticator;

/**
 * Class v0AuthenticatorTest
 *
 * @package Twigger\UnionCloud\Tests\Authentication
 */
class v0AuthenticatorTest extends TestCase
{

    /**
     * Holds an authenticator class
     *
     * @var v0Authenticator
     */
    private $authenticator;

    /**
     * Create a new authenticator
     */
    public function setUp()
    {
        $this->authenticator = new v0Authenticator();
        $this->authenticator->setParameters([
            'email' => $_ENV['EMAIL'],
            'password' => $_ENV['PASSWORD'],
            'appID' => $_ENV['APPID'],
            'appPassword' => $_ENV['EMAIL'],
        ]);
    }

    /**
     * Tests the validateParameters method of the v0 authenticator
     */
    public function testValidatesAuthParameters()
    {
        $parameters = [
            'email' => $_ENV['EMAIL'],
            'password' => $_ENV['PASSWORD'],
            'appID' => $_ENV['APPID'],
            'appPassword' => $_ENV['EMAIL'],
        ];
        $this->assertTrue($this->authenticator->validateParameters($parameters));
    }

}