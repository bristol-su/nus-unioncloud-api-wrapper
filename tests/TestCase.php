<?php
/**
 * Base Test Class
 */
namespace Twigger\UnionCloud\Tests;

use Dotenv\Dotenv;
use Twigger\UnionCloud\API\UnionCloud;

/**
 * Class TestCase
 *
 * @package Twigger\UnionCloud\Tests
 */
class TestCase extends \PHPUnit\Framework\TestCase
{

    /**
     * Example UnionCloud instance.
     *
     * This should be cloned for each new test, to prevent
     * any previous tests affecting the results of new tests
     *
     * @var UnionCloud
     */
    protected $unionCloud;

    /**
     * TestCase constructor.
     *
     * Extract the environment variables from testing.env
     *
     * Set up an example UnionCloud singleton,
     *
     * @param null|string $name
     * @param array $data
     * @param string $dataName
     *
     * @throws \Twigger\UnionCloud\API\Exception\Authentication\AuthenticationParameterMissing
     * @throws \Twigger\UnionCloud\API\Exception\Authentication\AuthenticatorNotFound
     */
    public function __construct($name = null, array $data = [], $dataName = '')
    {
        $dotEnv = new Dotenv(__DIR__.'/../', 'testing.env');
        $dotEnv->load();

        $unionCloud = new UnionCloud([
            'email' => $_ENV['EMAIL'],
            'password' => $_ENV['PASSWORD'],
            'appID' => $_ENV['APPID'],
            'appPassword' => $_ENV['EMAIL'],
        ]);
        $unionCloud->setBaseURL($_ENV['BASE_URL']);

        $this->unionCloud = $unionCloud;

        parent::__construct($name, $data, $dataName);
    }

}