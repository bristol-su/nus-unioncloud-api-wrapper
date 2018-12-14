<?php
/**
 * Base Test Class
 */
namespace Twigger\UnionCloud\Tests;

use Dotenv\Dotenv;

/**
 * Class TestCase
 *
 * @package Twigger\UnionCloud\Tests
 */
class TestCase extends \PHPUnit\Framework\TestCase
{

    /**
     * v0AuthenticatorTest constructor.
     *
     * Extract the environment variables from testing.env
     *
     * @param null $name
     * @param array $data
     * @param string $dataName
     */
    public function __construct($name = null, array $data = [], $dataName = '')
    {
        $dotEnv = new Dotenv(__DIR__.'/../', 'testing.env');
        $dotEnv->load();

        parent::__construct($name, $data, $dataName);
    }

}