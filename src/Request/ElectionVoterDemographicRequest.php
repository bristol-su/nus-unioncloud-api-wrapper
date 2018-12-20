<?php
/**
 * Election Voter Demographics Request class
 */
namespace Twigger\UnionCloud\API\Request;


use Twigger\UnionCloud\API\Auth\Authentication;
use Twigger\UnionCloud\API\Configuration;
use Twigger\UnionCloud\API\Response\ElectionVoterDemographicResponse;

/**
 * Class Election Voter Demographics Request
 *
 * @package Twigger\UnionCloud\API\Elections\ElectionVoterDemographics
 *
 * @license    https://opensource.org/licenses/GPL-3.0  GNU Public License v3
 *
 * @author     Toby Twigger <tt15951@bristol.ac.uk>
 *
 */
class ElectionVoterDemographicRequest extends BaseRequest implements IRequest
{
    /**
     * Election Voter Demographics Request constructor.
     *
     * @param Authentication $authentication
     * @param Configuration $configuration
     */
    public function __construct($authentication, $configuration)
    {
        parent::__construct($authentication, $configuration, ElectionVoterDemographicResponse::class);
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
     * Get election voter demographics for an election
     *
     * @param integer $electionID ID of the election
     * @param string $voterType actual or eligible
     *
     * @return $this|\Twigger\UnionCloud\API\Response\IResponse|\Twigger\UnionCloud\API\ResourceCollection
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Twigger\UnionCloud\API\Exception\Request\RequestHistoryNotFound
     * @throws \Twigger\UnionCloud\API\Exception\Response\BaseResponseException
     */
    public function getByElection($electionID, $voterType='actual')
    {
        $this->setAPIParameters(
            'elections/'.$electionID.'/election_voters_demographics',
            'GET'
        );

        $this->addQueryParameter('voter_type', $voterType);

        $this->enableMode();
        $this->enablePagination();
        $this->enableTimes();

        $this->call();

        return $this->getReturnDetails();
    }

}