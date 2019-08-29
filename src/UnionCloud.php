<?php
/**
 * UnionCloud Wrapper Class
 */

namespace Twigger\UnionCloud\API;

use Twigger\UnionCloud\API\Auth\Authentication;
use Twigger\UnionCloud\API\Auth\IAuthenticator;
use Twigger\UnionCloud\API\Exception\Authentication\AuthenticatorNotFound;
use Twigger\UnionCloud\API\Exception\Authentication\BaseUnionCloudAuthenticationException;
use Twigger\UnionCloud\API\Request;

/**
 * Class UnionCloud
 *
 * Choose your resource from here!
 *
 * @package Twigger\UnionCloud\API\Core
 * @license    https://opensource.org/licenses/GPL-3.0  GNU Public License v3
 * @author     Toby Twigger <tt15951@bristol.ac.uk>
 */

class UnionCloud
{


    /*
    |--------------------------------------------------------------------------
    | Class Holders
    |--------------------------------------------------------------------------
    |
    | Holders for the authenticator and configuration
    |
    */

    /**
     * Holds the Authentication wrapper, a wrapper for the authenticator
     *
     * @var Authentication
     */
    protected $authentication = null;

    /**
     * Holds configuration variables
     *      - Base URL
     *      - Debug
     * @var Configuration
     */
    protected $configuration;


    /**
     * UnionCloud constructor.
     *
     * Creates an Authenticator and a blank Configuration
     *
     * @param null|array $authParams Associative array of the Authentication Parameters
     * @param null|string $authenticator AuthenticatorClass::class
     * @param Authentication|null $authentication
     * @param Configuration|null $configuration
     *
     * @throws AuthenticatorNotFound
     * @throws Exception\Authentication\AuthenticationParameterMissing
     */
    public function __construct($authParams = null, $authenticator = null, Authentication $authentication = null, Configuration $configuration = null)
    {
        if($authentication === null) {
            $this->authentication = new Authentication($authParams, $authenticator);
        } else {
            $this->authentication = $authentication;
        }

        if($configuration === null) {
            $this->configuration = new Configuration;
        } else {
            $this->configuration = $configuration;
        }
    }

    /**
     * Manually set the authenticator
     *
     * @param IAuthenticator $authenticator
     *
     * @throws BaseUnionCloudAuthenticationException
     */
    public function setAuthenticator($authenticator)
    {
        $this->authentication->setAuthenticator($authenticator);
    }

    /**
     * Check UnionCloud is ready for the request
     *
     * @throws AuthenticatorNotFound
     *
     * @return void
     */
    private function checkReadyForRequest()
    {
        if (!$this->authentication->hasAuthentication())
        {
            throw new AuthenticatorNotFound();
        }
        return;
    }

    /**
     * Set the Base URL in the configuration class
     *
     * @param string $baseURL
     */
    public function setBaseURL($baseURL)
    {
        $this->configuration->setBaseUrl($baseURL);
    }

    /**
     * Set the debug status of the API call.
     *
     * By calling debug(), you'll see a lot more details
     * about the API call.
     *
     * @param bool $debug Defaults to true
     */
    public function debug($debug = true)
    {
        $this->configuration->setDebug($debug);
    }


    /*
   |--------------------------------------------------------------------------
   | API Request Classes
   |--------------------------------------------------------------------------
   |
   | A set of functions which return request classes, allowing access to
   | the methods of each resource
   |
   */

    /**
     * Return an election category resource request.
     *
     * @return Request\ElectionCategoryRequest
     *
     * @throws AuthenticatorNotFound
     */
    public function electionCategories()
    {
        $this->checkReadyForRequest();
        return new Request\ElectionCategoryRequest($this->authentication, $this->configuration);
    }

    /**
     * Return a Election Position resource request.
     *
     * @return Request\ElectionPositionRequest
     *
     * @throws AuthenticatorNotFound
     */
    public function electionPositions()
    {
        $this->checkReadyForRequest();
        return new Request\ElectionPositionRequest($this->authentication, $this->configuration);
    }

    /**
     * Return a Election resource request.
     *
     * @return Request\ElectionRequest
     *
     * @throws AuthenticatorNotFound
     */
    public function elections()
    {
        $this->checkReadyForRequest();
        return new Request\ElectionRequest($this->authentication, $this->configuration);
    }

    /**
     * Return a election standing resource request.
     *
     * @return Request\ElectionStandingRequest
     *
     * @throws AuthenticatorNotFound
     */
    public function electionStandings()
    {
        $this->checkReadyForRequest();
        return new Request\ElectionStandingRequest($this->authentication, $this->configuration);
    }

    /**
     * Return a election voter demographic resource request.
     *
     * @return Request\ElectionVoterDemographicRequest
     *
     * @throws AuthenticatorNotFound
     */
    public function electionVoterDemographics()
    {
        $this->checkReadyForRequest();
        return new Request\ElectionVoterDemographicRequest($this->authentication, $this->configuration);
    }

    /**
     * Return a election vote resource request.
     *
     * @return Request\ElectionVoteRequest
     *
     * @throws AuthenticatorNotFound
     */
    public function electionVotes()
    {
        $this->checkReadyForRequest();
        return new Request\ElectionVoteRequest($this->authentication, $this->configuration);
    }

    /**
     * Return a election voter resource request.
     *
     * @return Request\ElectionVoterRequest
     *
     * @throws AuthenticatorNotFound
     */
    public function electionVoters()
    {
        $this->checkReadyForRequest();
        return new Request\ElectionVoterRequest($this->authentication, $this->configuration);
    }

    /**
     * Return a event Attendee resource request.
     *
     * @return Request\EventAttendeeRequest
     *
     * @throws AuthenticatorNotFound
     */
    public function eventAttendees()
    {
        $this->checkReadyForRequest();
        return new Request\EventAttendeeRequest($this->authentication, $this->configuration);
    }

    /**
     * Return a event question resource request.
     *
     * @return Request\EventQuestionRequest
     *
     * @throws AuthenticatorNotFound
     */
    public function eventQuestions()
    {
        $this->checkReadyForRequest();
        return new Request\EventQuestionRequest($this->authentication, $this->configuration);
    }

    /**
     * Return a event resource request.
     *
     * @return Request\EventRequest
     *
     * @throws AuthenticatorNotFound
     */
    public function events()
    {
        $this->checkReadyForRequest();
        return new Request\EventRequest($this->authentication, $this->configuration);
    }
    /**
     * Return a event ticket resource request.
     *
     * @return Request\EventTicketRequest
     *
     * @throws AuthenticatorNotFound
     */
    public function eventTickets()
    {
        $this->checkReadyForRequest();
        return new Request\EventTicketRequest($this->authentication, $this->configuration);
    }

    /**
     * Return a event ticket type resource request.
     *
     * @return Request\EventTicketTypeRequest
     *
     * @throws AuthenticatorNotFound
     */
    public function eventTicketTypes()
    {
        $this->checkReadyForRequest();
        return new Request\EventTicketTypeRequest($this->authentication, $this->configuration);
    }

    /**
     * Return a event type resource request.
     *
     * @return Request\EventTypeRequest
     *
     * @throws AuthenticatorNotFound
     */
    public function eventTypes()
    {
        $this->checkReadyForRequest();
        return new Request\EventTypeRequest($this->authentication, $this->configuration);
    }

    /**
     * Return a group membership resource request.
     *
     * @return Request\GroupMembershipRequest
     *
     * @throws AuthenticatorNotFound
     */
    public function groupMemberships()
    {
        $this->checkReadyForRequest();
        return new Request\GroupMembershipRequest($this->authentication, $this->configuration);
    }

    /**
     * Return a group resource request.
     *
     * @return Request\GroupRequest
     *
     * @throws AuthenticatorNotFound
     */
    public function groups()
    {
        $this->checkReadyForRequest();
        return new Request\GroupRequest($this->authentication, $this->configuration);
    }


    /**
     * Return a programme resource request.
     *
     * @return Request\ProgrammeRequest
     *
     * @throws AuthenticatorNotFound
     */
    public function programmes()
    {
        $this->checkReadyForRequest();
        return new Request\ProgrammeRequest($this->authentication, $this->configuration);
    }

    /**
     * Return a UserGroup Folder resource request.
     *
     * @return Request\UserGroupFolderRequest
     *
     * @throws AuthenticatorNotFound
     */
    public function userGroupFolders()
    {
        $this->checkReadyForRequest();
        return new Request\UserGroupFolderRequest($this->authentication, $this->configuration);
    }

    /**
     * Return a UserGroup Membership resource request.
     *
     * @return Request\UserGroupMembershipRequest
     *
     * @throws AuthenticatorNotFound
     */
    public function userGroupMemberships()
    {
        $this->checkReadyForRequest();
        return new Request\UserGroupMembershipRequest($this->authentication, $this->configuration);
    }

    /**
     * Return a usergroup resource request.
     *
     * @return Request\UserGroupRequest
     *
     * @throws AuthenticatorNotFound
     */
    public function userGroups()
    {
        $this->checkReadyForRequest();
        return new Request\UserGroupRequest($this->authentication, $this->configuration);
    }

    /**
     * Return a user resource request.
     *
     * @return Request\UserRequest
     *
     * @throws AuthenticatorNotFound
     */
    public function users()
    {
        $this->checkReadyForRequest();
        return new Request\UserRequest($this->authentication, $this->configuration);
    }

}