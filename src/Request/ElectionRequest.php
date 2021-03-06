<?php
/**
 * Election Request class
 */
namespace Twigger\UnionCloud\API\Request;


use Twigger\UnionCloud\API\Auth\Authentication;
use Twigger\UnionCloud\API\Configuration;
use Twigger\UnionCloud\API\Response\ElectionResponse;

/**
 * Class Election Request
 *
 * @package Twigger\UnionCloud\API\Elections\Elections
 *
 * @license    https://opensource.org/licenses/GPL-3.0  GNU Public License v3
 *
 * @author     Toby Twigger <tt15951@bristol.ac.uk>
 *
 */
class ElectionRequest extends BaseRequest implements IRequest
{
    /**
     * Election Request constructor.
     *
     * @param Authentication $authentication
     * @param Configuration $configuration
     */
    public function __construct($authentication, $configuration)
    {
        parent::__construct($authentication, $configuration, ElectionResponse::class);
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
     * Get all elections
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
            'elections',
            'GET'
        );

        $this->enableMode();
        $this->enablePagination();
        $this->enableTimes();

        $this->call();

        return $this->getReturnDetails();
    }

    /**
     * Get a specific election
     *
     * @param integer $electionID ID of the election
     * @return $this|\Twigger\UnionCloud\API\Response\IResponse|\Twigger\UnionCloud\API\ResourceCollection
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Twigger\UnionCloud\API\Exception\Request\RequestHistoryNotFound
     * @throws \Twigger\UnionCloud\API\Exception\Response\BaseResponseException
     */
    public function getByID($electionID)
    {
        $this->setAPIParameters(
            'elections/'.$electionID,
            'GET'
        );

        $this->enableMode();

        $this->call();

        return $this->getReturnDetails();
    }

}