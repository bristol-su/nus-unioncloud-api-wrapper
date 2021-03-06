<?php
/**
 * Election Standing Request class
 */
namespace Twigger\UnionCloud\API\Request;


use Twigger\UnionCloud\API\Auth\Authentication;
use Twigger\UnionCloud\API\Configuration;
use Twigger\UnionCloud\API\Response\ElectionStandingResponse;

/**
 * Class Election Standing Request
 *
 * @package Twigger\UnionCloud\API\Elections\ElectionStandings
 *
 * @license    https://opensource.org/licenses/GPL-3.0  GNU Public License v3
 *
 * @author     Toby Twigger <tt15951@bristol.ac.uk>
 *
 */
class ElectionStandingRequest extends BaseRequest implements IRequest
{
    /**
     * Election Standing Request constructor.
     *
     * @param Authentication $authentication
     * @param Configuration $configuration
     */
    public function __construct($authentication, $configuration)
    {
        parent::__construct($authentication, $configuration, ElectionStandingResponse::class);
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
     * Get election standings for an election
     * 
     * @param integer $electionID ID of the election
     * 
     * @return $this|\Twigger\UnionCloud\API\Response\IResponse|\Twigger\UnionCloud\API\ResourceCollection
     * 
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Twigger\UnionCloud\API\Exception\Request\RequestHistoryNotFound
     * @throws \Twigger\UnionCloud\API\Exception\Response\BaseResponseException
     */
    public function getByElection($electionID)
    {
        $this->setAPIParameters(
            'elections/'.$electionID.'/election_standings',
            'GET'
        );
        
        $this->enableMode();
        $this->enablePagination();
        $this->enableTimes();
        
        $this->call();
        
        return $this->getReturnDetails();
    }

}