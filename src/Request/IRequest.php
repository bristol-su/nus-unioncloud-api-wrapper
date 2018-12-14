<?php
/**
 * IRequest Interface
 */
namespace Twigger\UnionCloud\API\Request;

use Twigger\UnionCloud\API\Auth\Authentication;
use Twigger\UnionCloud\API\Configuration;

/**
 * Interface IRequest
 *
 * @package Twigger\UnionCloud\API\Core\Requests
 */
interface IRequest
{

    /**
     * IRequest constructor.
     *
     * Pass the parameters received into the parent construct, along
     * with a class which is able to process the response
     *
     * parent::__construct($authentication, $configuration, BaseResponse::class);
     *
     * @param Authentication $authentication
     * @param Configuration $configuration
     */
    public function __construct($authentication, $configuration);

    /**
     * Get the instance of the Request class
     *
     * Implement as:
     *
     * public function getIntance()
     * {
     *      {
     *           return $this;
     *      }
     * }
     *
     *
     * @return BaseRequest
     */
    public function getInstance();


}