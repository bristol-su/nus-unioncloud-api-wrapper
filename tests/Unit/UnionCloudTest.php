<?php

namespace Twigger\UnionCloud\Tests\Unit;

use Twigger\UnionCloud\API\Auth\Authentication;
use Twigger\UnionCloud\API\Auth\IAuthenticator;
use Twigger\UnionCloud\API\Configuration;
use Twigger\UnionCloud\API\Exception\Authentication\AuthenticatorNotFound;
use Twigger\UnionCloud\API\Request\ElectionCategoryRequest;
use Twigger\UnionCloud\API\Request\ElectionPositionRequest;
use Twigger\UnionCloud\API\Request\ElectionRequest;
use Twigger\UnionCloud\API\Request\ElectionStandingRequest;
use Twigger\UnionCloud\API\Request\ElectionVoterDemographicRequest;
use Twigger\UnionCloud\API\Request\ElectionVoteRequest;
use Twigger\UnionCloud\API\Request\ElectionVoterRequest;
use Twigger\UnionCloud\API\Request\EventAttendeeRequest;
use Twigger\UnionCloud\API\Request\EventQuestionRequest;
use Twigger\UnionCloud\API\Request\EventRequest;
use Twigger\UnionCloud\API\Request\EventTicketRequest;
use Twigger\UnionCloud\API\Request\EventTicketTypeRequest;
use Twigger\UnionCloud\API\Request\EventTypeRequest;
use Twigger\UnionCloud\API\Request\GroupMembershipRequest;
use Twigger\UnionCloud\API\Request\GroupRequest;
use Twigger\UnionCloud\API\Request\ProgrammeRequest;
use Twigger\UnionCloud\API\Request\UserGroupFolderRequest;
use Twigger\UnionCloud\API\Request\UserGroupMembershipRequest;
use Twigger\UnionCloud\API\Request\UserGroupRequest;
use Twigger\UnionCloud\API\Request\UserRequest;
use Twigger\UnionCloud\API\UnionCloud;
use Twigger\UnionCloud\Tests\TestCase;

class UnionCloudTest extends TestCase
{

    private $authenticator;
    private $authentication;
    private $configuration;
    /**
     * @var UnionCloud
     */
    private $unionCloud;

    public function setUp()
    {
        $this->authenticator = $this->prophesize(IAuthenticator::class);
        $this->authentication = $this->prophesize(Authentication::class);
        $this->configuration = $this->prophesize(Configuration::class);
        $this->unionCloud = new UnionCloud(null, $this->authenticator->reveal(), $this->authentication->reveal(), $this->configuration->reveal());
    }

    /** @test */
    public function it_sets_the_authenticator(){
        $authenticator = $this->authenticator->reveal();
        $this->authentication->setAuthenticator($authenticator)->shouldBeCalled();

        $this->unionCloud->setAuthenticator($authenticator);
    }

    /** @test */
    public function it_sets_the_base_url(){
        $this->configuration->setBaseURL('baseUrl')->shouldBeCalled();

        $this->unionCloud->setBaseURL('baseUrl');
    }

    /** @test */
    public function it_turns_on_debug_mode(){
        $this->configuration->setDebug(true)->shouldBeCalled();

        $this->unionCloud->debug(true);
    }

    /** @test */
    public function it_returns_the_correct_class_for_each_method_group(){
        $this->authentication->hasAuthentication()->willReturn(true);
        $request = $this->unionCloud->groups();

        $this->assertInstanceOf(GroupRequest::class, $request);
    }

    /** @test */
    public function it_returns_the_correct_class_for_each_method_election_categories(){
        $this->authentication->hasAuthentication()->willReturn(true);
        $request = $this->unionCloud->electionCategories();

        $this->assertInstanceOf(ElectionCategoryRequest::class, $request);
    }

    /** @test */
    public function it_returns_the_correct_class_for_each_method_election_positions(){
        $this->authentication->hasAuthentication()->willReturn(true);
        $request = $this->unionCloud->electionPositions();

        $this->assertInstanceOf(ElectionPositionRequest::class, $request);
    }

    /** @test */
    public function it_returns_the_correct_class_for_each_method_elections(){
        $this->authentication->hasAuthentication()->willReturn(true);
        $request = $this->unionCloud->elections();

        $this->assertInstanceOf(ElectionRequest::class, $request);
    }

    /** @test */
    public function it_returns_the_correct_class_for_each_method_election_standings(){
        $this->authentication->hasAuthentication()->willReturn(true);
        $request = $this->unionCloud->electionStandings();

        $this->assertInstanceOf(ElectionStandingRequest::class, $request);
    }
    /** @test */
    public function it_returns_the_correct_class_for_each_method_election_voter_demographics(){
        $this->authentication->hasAuthentication()->willReturn(true);
        $request = $this->unionCloud->electionVoterDemographics();

        $this->assertInstanceOf(ElectionVoterDemographicRequest::class, $request);
    }

    /** @test */
    public function it_returns_the_correct_class_for_each_method_election_votes(){
        $this->authentication->hasAuthentication()->willReturn(true);
        $request = $this->unionCloud->electionVotes();

        $this->assertInstanceOf(ElectionVoteRequest::class, $request);
    }

    /** @test */
    public function it_returns_the_correct_class_for_each_method_election_voters(){
        $this->authentication->hasAuthentication()->willReturn(true);
        $request = $this->unionCloud->electionVoters();

        $this->assertInstanceOf(ElectionVoterRequest::class, $request);
    }

    /** @test */
    public function it_returns_the_correct_class_for_each_method_event_attendees() {
        $this->authentication->hasAuthentication()->willReturn(true);
        $request = $this->unionCloud->eventAttendees();

        $this->assertInstanceOf(EventAttendeeRequest::class, $request);
    }

    /** @test */
    public function it_returns_the_correct_class_for_each_method_event_questions(){
        $this->authentication->hasAuthentication()->willReturn(true);
        $request = $this->unionCloud->eventQuestions();

        $this->assertInstanceOf(EventQuestionRequest::class, $request);
    }

    /** @test */
    public function it_returns_the_correct_class_for_each_method_events(){
        $this->authentication->hasAuthentication()->willReturn(true);
        $request = $this->unionCloud->events();

        $this->assertInstanceOf(EventRequest::class, $request);
    }

    /** @test */
    public function it_returns_the_correct_class_for_each_method_event_tickets(){
        $this->authentication->hasAuthentication()->willReturn(true);
        $request = $this->unionCloud->eventTickets();

        $this->assertInstanceOf(EventTicketRequest::class, $request);
    }

    /** @test */
    public function it_returns_the_correct_class_for_each_method_event_ticket_types(){
        $this->authentication->hasAuthentication()->willReturn(true);
        $request = $this->unionCloud->eventTicketTypes();

        $this->assertInstanceOf(EventTicketTypeRequest::class, $request);
    }

    /** @test */
    public function it_returns_the_correct_class_for_each_method_event_types(){
        $this->authentication->hasAuthentication()->willReturn(true);
        $request = $this->unionCloud->eventTypes();

        $this->assertInstanceOf(EventTypeRequest::class, $request);
    }

    /** @test */
    public function it_returns_the_correct_class_for_each_method_group_memberships(){
        $this->authentication->hasAuthentication()->willReturn(true);
        $request = $this->unionCloud->groupMemberships();

        $this->assertInstanceOf(GroupMembershipRequest::class, $request);
    }

        /** @test */
    public function it_returns_the_correct_class_for_each_method_programmes(){
        $this->authentication->hasAuthentication()->willReturn(true);
        $request = $this->unionCloud->programmes();

        $this->assertInstanceOf(ProgrammeRequest::class, $request);
    }

        /** @test */
    public function it_returns_the_correct_class_for_each_method_user_group_folders(){
        $this->authentication->hasAuthentication()->willReturn(true);
        $request = $this->unionCloud->userGroupFolders();

        $this->assertInstanceOf(UserGroupFolderRequest::class, $request);
    }

        /** @test */
    public function it_returns_the_correct_class_for_each_method_user_group_memberships(){
        $this->authentication->hasAuthentication()->willReturn(true);
        $request = $this->unionCloud->userGroupMemberships();

        $this->assertInstanceOf(UserGroupMembershipRequest::class, $request);
    }

        /** @test */
    public function it_returns_the_correct_class_for_each_method_group_user_groups(){
        $this->authentication->hasAuthentication()->willReturn(true);
        $request = $this->unionCloud->userGroups();

        $this->assertInstanceOf(UserGroupRequest::class, $request);
    }

        /** @test */
    public function it_returns_the_correct_class_for_each_method_users(){
        $this->authentication->hasAuthentication()->willReturn(true);
        $request = $this->unionCloud->users();

        $this->assertInstanceOf(UserRequest::class, $request);
    }

}