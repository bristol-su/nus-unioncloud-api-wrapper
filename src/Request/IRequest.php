<?php
/**
 * IRequest Interface
 */
namespace Twigger\UnionCloud\Request;

use Twigger\UnionCloud\Auth\Authentication;
use Twigger\UnionCloud\Configuration;

/**
 * Interface IRequest
 *
 * @package Twigger\UnionCloud\Core\Requests
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