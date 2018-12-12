<?php
/**
 * UserRequest class
 */
namespace Twigger\UnionCloud\Request;


use Twigger\UnionCloud\Auth\Authentication;
use Twigger\UnionCloud\Configuration;
use Twigger\UnionCloud\Response\UserResponse;

/**
 * Class UserRequest
 *
 * @package Twigger\UnionCloud\Users\Users
 *
 * @license    https://opensource.org/licenses/GPL-3.0  GNU Public License v3
 *
 * @author     Toby Twigger <tt15951@bristol.ac.uk>
 *
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
     * Gets the current instance
     *
     * @return UserRequest
     *
     */
    public function getInstance()
    {
        return $this;
    }



    /*
    |--------------------------------------------------------------------------
    | API Endpoint Definitions
    |--------------------------------------------------------------------------
    |
    | Define your API endpoints below here
    |
    */
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
     * Get a User by their UID
     *
     * @param $uid
     *
     * @return $this|\Twigger\UnionCloud\Response\IResponse|\Twigger\UnionCloud\ResourceCollection
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Twigger\UnionCloud\Exception\Request\RequestHistoryNotFound
     * @throws \Twigger\UnionCloud\Exception\Response\BaseResponseException
     */
    public function getByUID($uid)
    {
        $this->setAPIParameters(
            'users/'.$uid,
            'GET'
        );

        $this->enableMode();

        $this->call();

        return $this->getReturnDetails();
    }
    

    /**
     * Update a user
     *
     * @param string $uid
     * @param array $parameters Associative array of parameters to update
     *
     * // TODO Calls like this should be made from the response. (i.e. edit the resource and call update() on it)
     *
     * @return $this|\Twigger\UnionCloud\Response\IResponse|\Twigger\UnionCloud\ResourceCollection
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Twigger\UnionCloud\Exception\Request\RequestHistoryNotFound
     * @throws \Twigger\UnionCloud\Exception\Response\BaseResponseException
     */
    public function update($uid, $parameters)
    {
        $this->setAPIParameters(
            'users/'.$uid,
            'PUT'
        );

        $this->call();

        return $this->getReturnDetails();
    }

    /**
     * Delete a user
     *
     * @param string $uid
     *
     * @return $this|\Twigger\UnionCloud\Response\IResponse|\Twigger\UnionCloud\ResourceCollection
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Twigger\UnionCloud\Exception\Request\RequestHistoryNotFound
     * @throws \Twigger\UnionCloud\Exception\Response\BaseResponseException
     */
    public function delete($uid)
    {
        $this->setAPIParameters(
            'users/'.$uid,
            'DELETE'
        );

        $this->call();

        return $this->getReturnDetails();
    }

    /**
     * Upload a Student
     * 
     * @param array $parameters Parameters of the new student
     * 
     * @return $this|\Twigger\UnionCloud\Response\IResponse|\Twigger\UnionCloud\ResourceCollection
     * 
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Twigger\UnionCloud\Exception\Request\RequestHistoryNotFound
     * @throws \Twigger\UnionCloud\Exception\Response\BaseResponseException
     */
    public function uploadStudent($parameters)
    {
        $this->setAPIParameters(
            'json/upload/students',
            'POST',
            $parameters
        );
        
        $this->call();
        
        return $this->getReturnDetails();
    }

    /**
     * Upload a Guest
     *
     * @param array $parameters Parameters of the new guest
     *
     * @return $this|\Twigger\UnionCloud\Response\IResponse|\Twigger\UnionCloud\ResourceCollection
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Twigger\UnionCloud\Exception\Request\RequestHistoryNotFound
     * @throws \Twigger\UnionCloud\Exception\Response\BaseResponseException
     */
    public function uploadGuest($parameters)
    {
        $this->setAPIParameters(
            'json/upload/guests',
            'POST',
            $parameters
        );

        $this->call();

        return $this->getReturnDetails();
    }

}