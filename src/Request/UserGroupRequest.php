<?php
/**
 * User Groups Request class
 */
namespace Twigger\UnionCloud\API\Request;


use Twigger\UnionCloud\API\Auth\Authentication;
use Twigger\UnionCloud\API\Configuration;
use Twigger\UnionCloud\API\Response\UserGroupResponse;

/**
 * Class User Groups Request
 *
 * @package Twigger\UnionCloud\API\UserGroups\UserGroups
 *
 * @license    https://opensource.org/licenses/GPL-3.0  GNU Public License v3
 *
 * @author     Toby Twigger <tt15951@bristol.ac.uk>
 *
 */
class UserGroupRequest extends BaseRequest implements IRequest
{
    /**
     * User Groups Request constructor.
     *
     * @param Authentication $authentication
     * @param Configuration $configuration
     */
    public function __construct($authentication, $configuration)
    {
        parent::__construct($authentication, $configuration, UserGroupResponse::class);
    }


    /**
     * Gets the current instance
     *
     * @return $this
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
     * Create a new UserGroup
     * 
     * @param string $ugName UserGroup Name
     * @param string $ugDescription UserGroup Description
     * @param integer $folderID ID of the folder to contain the UserGroup
     * 
     * @return $this|\Twigger\UnionCloud\API\Response\IResponse|\Twigger\UnionCloud\API\ResourceCollection
     * 
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Twigger\UnionCloud\API\Exception\Request\RequestHistoryNotFound
     * @throws \Twigger\UnionCloud\API\Exception\Response\BaseResponseException
     */
    public function create($ugName, $ugDescription, $folderID)
    {
        $this->setAPIParameters(
            'user_groups',
            'POST',
            [
                'ug_name' => $ugName,
                'ug_description' => $ugDescription,
                'folder_id' => $folderID
            ]
        );
        
        $this->call();
        
        return $this->getReturnDetails();
    }

    /**
     * Update a new UserGroup
     *
     * @param integer $ugID ID of the UserGroup
     * @param string $ugName UserGroup Name
     * @param string $ugDescription UserGroup Description
     * @param integer $folderID ID of the folder to contain the UserGroup
     *
     * @return $this|\Twigger\UnionCloud\API\Response\IResponse|\Twigger\UnionCloud\API\ResourceCollection
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Twigger\UnionCloud\API\Exception\Request\RequestHistoryNotFound
     * @throws \Twigger\UnionCloud\API\Exception\Response\BaseResponseException
     */
    public function update($ugID, $ugName, $ugDescription, $folderID)
    {
        $this->setAPIParameters(
            'user_groups/'.$ugID,
            'PUT',
            [
                'ug_name' => $ugName,
                'ug_description' => $ugDescription,
                'folder_id' => $folderID
            ]
        );

        $this->call();

        return $this->getReturnDetails();
    }

    /**
     * Delete a UserGroup
     *
     * @param integer $ugID ID of the UserGroup to delete
     *
     * @return $this|\Twigger\UnionCloud\API\Response\IResponse|\Twigger\UnionCloud\API\ResourceCollection
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Twigger\UnionCloud\API\Exception\Request\RequestHistoryNotFound
     * @throws \Twigger\UnionCloud\API\Exception\Response\BaseResponseException
     */
    public function delete($ugID)
    {
        $this->setAPIParameters(
            'user_groups/'.$ugID,
            'DELETE',
        );

        $this->call();

        return $this->getReturnDetails();
    }

    /**
     * Search for a UserGroup
     *
     * @param mixed[] $searchParameters Associative array of search parameters
     *
     * @return $this|\Twigger\UnionCloud\API\Response\IResponse|\Twigger\UnionCloud\API\ResourceCollection
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Twigger\UnionCloud\API\Exception\Request\RequestHistoryNotFound
     * @throws \Twigger\UnionCloud\API\Exception\Response\BaseResponseException
     */
    public function search($searchParameters)
    {
        $this->setAPIParameters(
            'user_groups/search',
            'POST',
            $searchParameters
        );

        $this->enableMode();
        $this->enablePagination();

        $this->call();

        return $this->getReturnDetails();
    }

    /**
     * Get all UserGroups in the Union
     *
     * @return $this|\Twigger\UnionCloud\API\Response\IResponse|\Twigger\UnionCloud\API\ResourceCollection
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Twigger\UnionCloud\API\Exception\Request\RequestHistoryNotFound
     * @throws \Twigger\UnionCloud\API\Exception\Response\BaseResponseException
     */
    public function getAll()
    {
        $this->setAPIParameters(
            'user_groups',
            'GET'
        );

        $this->enableMode();
        $this->enablePagination();
        $this->enableTimes();

        $this->call();

        return $this->getReturnDetails();
    }

    /**
     * Get a specific UserGroup
     *
     * @param integer $ugID ID of the UserGroup
     *
     * @return $this|\Twigger\UnionCloud\API\Response\IResponse|\Twigger\UnionCloud\API\ResourceCollection
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Twigger\UnionCloud\API\Exception\Request\RequestHistoryNotFound
     * @throws \Twigger\UnionCloud\API\Exception\Response\BaseResponseException
     */
    public function getByID($ugID)
    {
        $this->setAPIParameters(
            'user_groups/'.$ugID,
            'GET'
        );

        $this->enableMode();

        $this->call();

        return $this->getReturnDetails();
    }

}