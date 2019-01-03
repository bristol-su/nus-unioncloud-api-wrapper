<?php
/**
 * UserGroup Membership Request class
 */
namespace Twigger\UnionCloud\API\Request;


use Carbon\Carbon;
use Twigger\UnionCloud\API\Auth\Authentication;
use Twigger\UnionCloud\API\Configuration;
use Twigger\UnionCloud\API\Response\UserGroupMembershipResponse;

/**
 * Class UserRequest
 *
 * @package Twigger\UnionCloud\API\UserGroups\UserGroupMemberships
 *
 * @license    https://opensource.org/licenses/GPL-3.0  GNU Public License v3
 *
 * @author     Toby Twigger <tt15951@bristol.ac.uk>
 *
 */
class UserGroupMembershipRequest extends BaseRequest implements IRequest
{
    /**
     * UserGroup Membership Request constructor.
     *
     * @param Authentication $authentication
     * @param Configuration $configuration
     */
    public function __construct($authentication, $configuration)
    {
        parent::__construct($authentication, $configuration, UserGroupMembershipResponse::class);
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
     * Get all UserGroup Memberships for a specific UserGroup
     *
     * @param integer $ugID ID of the UserGroup to get UGMs from
     * @param Carbon $from Get all that exist beyond this time
     * @param Carbon $to Get all that exist before this time
     *
     * @return $this|\Twigger\UnionCloud\API\Response\IResponse|\Twigger\UnionCloud\API\ResourceCollection
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Twigger\UnionCloud\API\Exception\Request\RequestHistoryNotFound
     * @throws \Twigger\UnionCloud\API\Exception\Response\BaseResponseException
     */
    public function getByUserGroup($ugID, $from, $to)
    {
        $this->setAPIParameters(
            'user_groups/'.$ugID.'/user_group_memberships',
            'GET'
        );

        $this->addQueryParameter('from', $from->format('d-m-Y'));
        $this->addQueryParameter('to', $to->format('d-m-Y'));

        $this->enableMode();
        $this->enablePagination();

        $this->call();

        return $this->getReturnDetails();
    }

    /**
     * Create a new UserGroup Membership
     *
     * @param int $uid UID of the User
     * @param int $ugID UserGroup ID
     * @param Carbon $expiry Expiry Date of the UGM
     *
     * @return $this|\Twigger\UnionCloud\API\Response\IResponse|\Twigger\UnionCloud\API\ResourceCollection
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Twigger\UnionCloud\API\Exception\Request\RequestHistoryNotFound
     * @throws \Twigger\UnionCloud\API\Exception\Response\BaseResponseException
     */
    public function create($uid, $ugID, $expiry)
    {
        $this->setAPIParameters(
            'user_group_memberships',
            'POST',
            [
                'uid' => $uid,
                'ug_id' => $ugID,
                'expire_date' => $expiry->format('d-m-Y')
            ]
        );

        $this->call();

        return $this->getReturnDetails();
    }

    /**
     * Create multiple new UserGroup Memberships
     *
     * @param mixed[] $ugms array of arrays, containing the keys uid, ug_id and expire_date
     *
     * @return $this|\Twigger\UnionCloud\API\Response\IResponse|\Twigger\UnionCloud\API\ResourceCollection
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Twigger\UnionCloud\API\Exception\Request\RequestHistoryNotFound
     * @throws \Twigger\UnionCloud\API\Exception\Response\BaseResponseException
     */
    public function createMultiple($ugms)
    {
        $this->setAPIParameters(
            'user_group_memberships/upload',
            'POST',
            $ugms
        );

        $this->call();

        return $this->getReturnDetails();
    }

    /**
     * Update a UserGroup Membership
     *
     * @param int $ugmID UserGroup Membership ID
     * @param Carbon $expiry Expiry Date of the UGM
     *
     * @return $this|\Twigger\UnionCloud\API\Response\IResponse|\Twigger\UnionCloud\API\ResourceCollection
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Twigger\UnionCloud\API\Exception\Request\RequestHistoryNotFound
     * @throws \Twigger\UnionCloud\API\Exception\Response\BaseResponseException
     */
    public function update($ugmID, $expiry)
    {
        $this->setAPIParameters(
            'user_group_memberships/'.$ugmID,
            'PUT',
            [
                'expire_date' => $expiry->format('d-m-Y')
            ]
        );

        $this->call();

        return $this->getReturnDetails();
    }


    /**
     * Delete a UserGroup Membership
     *
     * @param int $ugmID UserGroup Membership ID
     *
     * @return $this|\Twigger\UnionCloud\API\Response\IResponse|\Twigger\UnionCloud\API\ResourceCollection
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Twigger\UnionCloud\API\Exception\Request\RequestHistoryNotFound
     * @throws \Twigger\UnionCloud\API\Exception\Response\BaseResponseException
     */
    public function delete($ugmID)
    {
        $this->setAPIParameters(
            'user_group_memberships/'.$ugmID,
            'DELETE'
        );

        $this->call();

        return $this->getReturnDetails();
    }

    /**
     * Delete multiple UserGroup Memberships
     *
     * @param mixed[] $ugms Array of UserGroup Membership IDs
     *
     * @return $this|\Twigger\UnionCloud\API\Response\IResponse|\Twigger\UnionCloud\API\ResourceCollection
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Twigger\UnionCloud\API\Exception\Request\RequestHistoryNotFound
     * @throws \Twigger\UnionCloud\API\Exception\Response\BaseResponseException
     */
    public function deleteMultiple($ugms)
    {
        $userGroupMemberships = [];
        foreach($ugms as $ugm)
        {
            $userGroupMemberships[] = ['ugm_id' => $ugm];
        }

        $this->setAPIParameters(
            'user_group_memberships/upload',
            'POST',
            $userGroupMemberships
        );

        $this->call();

        return $this->getReturnDetails();
    }

    /**
     * Get all UserGroup Memberships belonging to a User
     *
     * @param int $uid User ID
     *
     * @return $this|\Twigger\UnionCloud\API\Response\IResponse|\Twigger\UnionCloud\API\ResourceCollection
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Twigger\UnionCloud\API\Exception\Request\RequestHistoryNotFound
     * @throws \Twigger\UnionCloud\API\Exception\Response\BaseResponseException
     */
    public function getByUser($uid)
    {
        $this->setAPIParameters(
            'users/'.$uid.'/user_group_memberships',
            'GET'
        );

        $this->enableMode();
        $this->enablePagination();
        $this->enableTimes();

        $this->call();

        return $this->getReturnDetails();
    }

}