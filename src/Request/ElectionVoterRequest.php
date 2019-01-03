<?php
/**
 * Election Voter Request class
 */
namespace Twigger\UnionCloud\API\Request;


use Twigger\UnionCloud\API\Auth\Authentication;
use Twigger\UnionCloud\API\Configuration;
use Twigger\UnionCloud\API\Response\ElectionVoterResponse;

/**
 * Class Election Voter Request
 *
 * @package Twigger\UnionCloud\API\Elections\ElectionVoters
 *
 * @license    https://opensource.org/licenses/GPL-3.0  GNU Public License v3
 *
 * @author     Toby Twigger <tt15951@bristol.ac.uk>
 *
 */
class ElectionVoterRequest extends BaseRequest implements IRequest
{
    /**
     * Election Voter Request constructor.
     *
     * @param Authentication $authentication
     * @param Configuration $configuration
     */
    public function __construct($authentication, $configuration)
    {
        parent::__construct($authentication, $configuration, ElectionVoterResponse::class);
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
     * Get election voters for an election
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
            'elections/'.$electionID.'/election_voters',
            'GET'
        );

        $this->addQueryParameter('voter_type', $voterType);

        $this->enablePagination();

        $this->call();

        return $this->getReturnDetails();
    }

}