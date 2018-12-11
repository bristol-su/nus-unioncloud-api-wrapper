<?php
/**
 * UserRequest class
 */
namespace Twigger\UnionCloud\Request;


use Twigger\UnionCloud\Auth\Authentication;
use Twigger\UnionCloud\Configuration;
use Twigger\UnionCloud\IAuthenticator;
use Twigger\UnionCloud\ResourceCollection;
use Twigger\UnionCloud\Response\UserResponse;

/**
 * Class UserRequest
 *
 * @package Twigger\UnionCloud
 *
 * @license    https://opensource.org/licenses/GPL-3.0  GNU Public License v3
 *
 * @author     Toby Twigger <tt15951@bristol.ac.uk>
 */
class UserRequest extends BaseRequest implements IRequest
{
    /**
     * UserRequest constructor.
     *
     * @param Authentication $authentication
     * @param Configuration $configuration
     */
    public function __construct($authentication, $configuration)
    {
        parent::__construct($authentication, $configuration, UserResponse::class);
    }



    /**
     * Search for a user by a variety of parameters
     *
     * Pass the parameters as [
     *      'parameter-name'=>'parameter-value'
     * ]
     *
     * The possible parameters are:
     *      - //TODO
     *
     * @param array $parameters Parameter to search for a user with
     *
     * @return $this|\Twigger\UnionCloud\Response\IResponse|\Twigger\UnionCloud\ResourceCollection
     *
     * @throws \Twigger\UnionCloud\Exception\Request\RequestHistoryNotFound
     * @throws \Twigger\UnionCloud\Exception\Response\BaseResponseException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function search($parameters)
    {
        // Set the parameters to make the call
        $this->setAPIParameters(
            'users/search',
            'POST',
            $parameters
        );

        $this->enablePagination();
        $this->enableMode();

        $this->call();


        return $this->getReturnDetails();
    }

    /**
     * Gets the current instance
     *
     * @return UserRequest
     *
     */
    public function getInstance()
    {
        return $this;
    }


}