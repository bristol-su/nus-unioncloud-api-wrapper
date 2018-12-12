<?php
/**
 * UserGroup Membership Request class
 */
namespace Twigger\UnionCloud\Request;


use Carbon\Carbon;
use Twigger\UnionCloud\Auth\Authentication;
use Twigger\UnionCloud\Configuration;
use Twigger\UnionCloud\Response\UserGroupMembershipResponse;

/**
 * Class UserRequest
 *
 * @package Twigger\UnionCloud\UserGroups\UserGroupMemberships
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
     * Get UserGroup Memberships belonging to a certain user
     * 
     * @param string $uid UID of the user
     * @param Carbon $updatedAfter Date which the user group membership should have been updated after
     * @param Carbon $updatedBefore Date which the user group membership should have been updated before
     * 
     * @return $this|\Twigger\UnionCloud\Response\IResponse|\Twigger\UnionCloud\ResourceCollection
     * 
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Twigger\UnionCloud\Exception\Request\RequestHistoryNotFound
     * @throws \Twigger\UnionCloud\Exception\Response\BaseResponseException
     */
    public function users($uid, $updatedAfter = null, $updatedBefore = null)
    {
        $this->setAPIParameters(
            'users/'.$uid.'/user_group_memberships',
            'GET'
        );

        if($updatedAfter !== null) { $this->addQueryParameter('updated_at_after', $updatedAfter->format('d-m-y H:i:s')); }
        if($updatedBefore !== null) { $this->addQueryParameter('updated_at_before', $updatedBefore->format('d-m-y H:i:s')); }

        $this->enableMode();
        $this->enablePagination();
        
        $this->call();
        
        return $this->getReturnDetails();
    }



}