<?php
/**
 * Group Request class
 */
namespace Twigger\UnionCloud\API\Request;


use Twigger\UnionCloud\API\Auth\Authentication;
use Twigger\UnionCloud\API\Configuration;
use Twigger\UnionCloud\API\Response\GroupResponse;

/**
 * Class Group Request
 *
 * @package Twigger\UnionCloud\API\Groups\Groups
 *
 * @license    https://opensource.org/licenses/GPL-3.0  GNU Public License v3
 *
 * @author     Toby Twigger <tt15951@bristol.ac.uk>
 *
 */
class GroupRequest extends BaseRequest implements IRequest
{
    /**
     * Group Request constructor.
     *
     * @param Authentication $authentication
     * @param Configuration $configuration
     */
    public function __construct($authentication, $configuration)
    {
        parent::__construct($authentication, $configuration, GroupResponse::class);
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
     * Get all groups from the union
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
            'groups',
            'GET'
        );
        
        $this->enableMode();
        $this->enablePagination();
        $this->enableTimes();
        
        $this->call();
        
        return $this->getReturnDetails();
    }

    /**
     * Get a group from UnionCloud
     *
     * @param integer $groupID ID of the group to get
     *
     * @return $this|\Twigger\UnionCloud\API\Response\IResponse|\Twigger\UnionCloud\API\ResourceCollection
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Twigger\UnionCloud\API\Exception\Request\RequestHistoryNotFound
     * @throws \Twigger\UnionCloud\API\Exception\Response\BaseResponseException
     */
    public function getByID($groupID)
    {
        $this->setAPIParameters(
            'groups/'.$groupID,
            'GET'
        );

        $this->enableMode();

        $this->call();

        return $this->getReturnDetails();
    }

    /**
     * Join a Group on UnionCloud
     *
     * @param integer $groupID ID of the group to join
     * @param integer $uid UID of the User joining the group
     * @param integer $group_membership_id ID of the group membership for the user
     *
     * @return $this|\Twigger\UnionCloud\API\Response\IResponse|\Twigger\UnionCloud\API\ResourceCollection
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Twigger\UnionCloud\API\Exception\Request\RequestHistoryNotFound
     * @throws \Twigger\UnionCloud\API\Exception\Response\BaseResponseException
     */
    public function join($groupID, $uid, $group_membership_id)
    {
        $this->setAPIParameters(
            'groups/'.$groupID.'/join',
            'POST',
            [
                'uid' => $uid,
                'membership_type_id' => $group_membership_id
            ]
        );

        $this->call();

        return $this->getReturnDetails();
    }

}