<?php
/**
 * UserRequest class
 */
namespace Twigger\UnionCloud\API\Request;


use Twigger\UnionCloud\API\Auth\Authentication;
use Twigger\UnionCloud\API\Configuration;
use Twigger\UnionCloud\API\Response\UserResponse;

/**
 * Class UserRequest
 *
 * @package Twigger\UnionCloud\API\Users\Users
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
     * Get all available users
     *
     * Pass the parameters as [
     *      'parameter-name'=>'parameter-value'
     * ]
     *
     * @param array $parameters Parameter to search for a user with
     *
     * @return $this|\Twigger\UnionCloud\API\Response\IResponse|\Twigger\UnionCloud\API\ResourceCollection
     *
     * @throws \Twigger\UnionCloud\API\Exception\Request\RequestHistoryNotFound
     * @throws \Twigger\UnionCloud\API\Exception\Response\BaseResponseException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function all($parameters)
    {
        // Set the parameters to make the call
        $this->setAPIParameters(
            'users',
            'GET',
            $parameters
        );

        $this->enablePagination();
        $this->enableMode();

        $this->call();


        return $this->getReturnDetails();
    }

    /**
     * Search for a user by a variety of parameters
     *
     * Pass the parameters as [
     *      'parameter-name'=>'parameter-value'
     * ]
     *
     * @param array $parameters Parameter to search for a user with
     * @param boolean $searchAcrossEmail Should the API search across all email fields?
     *
     * @return $this|\Twigger\UnionCloud\API\Response\IResponse|\Twigger\UnionCloud\API\ResourceCollection
     *
     * @throws \Twigger\UnionCloud\API\Exception\Request\RequestHistoryNotFound
     * @throws \Twigger\UnionCloud\API\Exception\Response\BaseResponseException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function search($parameters, $searchAcrossEmail = true)
    {
        // Set the parameters to make the call
        $this->setAPIParameters(
            'users/search',
            'POST',
            $parameters
        );

        $this->addQueryParameter('search_across_email', $searchAcrossEmail);

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
     * @return $this|\Twigger\UnionCloud\API\Response\IResponse|\Twigger\UnionCloud\API\ResourceCollection
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Twigger\UnionCloud\API\Exception\Request\RequestHistoryNotFound
     * @throws \Twigger\UnionCloud\API\Exception\Response\BaseResponseException
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
     * @return $this|\Twigger\UnionCloud\API\Response\IResponse|\Twigger\UnionCloud\API\ResourceCollection
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Twigger\UnionCloud\API\Exception\Request\RequestHistoryNotFound
     * @throws \Twigger\UnionCloud\API\Exception\Response\BaseResponseException
     */
    public function update($uid, $parameters)
    {
        $this->setAPIParameters(
            'users/'.$uid,
            'PUT',
            $parameters
        );

        $this->call();

        return $this->getReturnDetails();
    }

    /**
     * Delete a user
     *
     * @param string $uid
     *
     * @return $this|\Twigger\UnionCloud\API\Response\IResponse|\Twigger\UnionCloud\API\ResourceCollection
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Twigger\UnionCloud\API\Exception\Request\RequestHistoryNotFound
     * @throws \Twigger\UnionCloud\API\Exception\Response\BaseResponseException
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
     * @param array $details Parameters of the new student
     * 
     * @return $this|\Twigger\UnionCloud\API\Response\IResponse|\Twigger\UnionCloud\API\ResourceCollection
     * 
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Twigger\UnionCloud\API\Exception\Request\RequestHistoryNotFound
     * @throws \Twigger\UnionCloud\API\Exception\Response\BaseResponseException
     */
    public function uploadStudent($details)
    {
        $this->setAPIParameters(
            'json/upload/students',
            'POST',
            $details
        );
        
        $this->call();
        
        return $this->getReturnDetails();
    }

    /**
     * Upload a Guest
     *
     * @param array $details Parameters of the new guest
     *
     * @return $this|\Twigger\UnionCloud\API\Response\IResponse|\Twigger\UnionCloud\API\ResourceCollection
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Twigger\UnionCloud\API\Exception\Request\RequestHistoryNotFound
     * @throws \Twigger\UnionCloud\API\Exception\Response\BaseResponseException
     */
    public function uploadGuest($details)
    {
        $this->setAPIParameters(
            'json/upload/guests',
            'POST',
            $details
        );

        $this->call();

        return $this->getReturnDetails();
    }

}