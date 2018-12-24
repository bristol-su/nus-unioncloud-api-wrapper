<?php
/**
 * v0Authenticator Test
 */
namespace Twigger\UnionCloud\Tests\Resources;

use Twigger\UnionCloud\API\UnionCloud;
use Twigger\UnionCloud\Tests\TestCase;

/**
 * Class v0AuthenticatorTest
 *
 * @package Twigger\UnionCloud\Tests
 */
class tempTest extends TestCase
{

    /**
     * Holds an authenticator class
     *
     * @var UnionCloud
     */
    public $unionCloud;

    public function __construct($name = null, array $data = [], $dataName = '')
    {


        parent::__construct($name, $data, $dataName);
    }

    /**
     *
     */
    public function testSomething()
    {
        $this->expectOutputString(print_r($this->unionCloud, true));
    }

}