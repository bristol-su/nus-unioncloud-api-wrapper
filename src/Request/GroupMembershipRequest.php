<?php
/**
 * Group Membership Request class
 */
namespace Twigger\UnionCloud\API\Request;


use Twigger\UnionCloud\API\Auth\Authentication;
use Twigger\UnionCloud\API\Configuration;
use Twigger\UnionCloud\API\Response\GroupMembershipResponse;

/**
 * Class Group Membership Request
 *
 * @package Twigger\UnionCloud\API\Groups\GroupMemberships
 *
 * @license    https://opensource.org/licenses/GPL-3.0  GNU Public License v3
 *
 * @author     Toby Twigger <tt15951@bristol.ac.uk>
 *
 */
class GroupMembershipRequest extends BaseRequest implements IRequest
{
    /**
     * Group Membership Request constructor.
     *
     * @param Authentication $authentication
     * @param Configuration $configuration
     */
    public function __construct($authentication, $configuration)
    {
        parent::__construct($authentication, $configuration, GroupMembershipResponse::class);
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
     * Get all group memberships owned by a user
     * 
     * @param integer $uid User ID
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
            'users/'.$uid.'/group_memberships',
            'GET'
        );
        
        $this->enableMode();
        $this->enablePagination();
        
        $this->call();
        
        return $this->getReturnDetails();
    }

}