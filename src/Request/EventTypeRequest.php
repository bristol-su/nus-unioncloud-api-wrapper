<?php
/**
 * Event Type Request class
 */
namespace Twigger\UnionCloud\API\Request;


use Twigger\UnionCloud\API\Auth\Authentication;
use Twigger\UnionCloud\API\Configuration;
use Twigger\UnionCloud\API\Response\EventTypeResponse;

/**
 * Class Event Type Request
 *
 * @package Twigger\UnionCloud\API\Events\EventTypes
 *
 * @license    https://opensource.org/licenses/GPL-3.0  GNU Public License v3
 *
 * @author     Toby Twigger <tt15951@bristol.ac.uk>
 *
 */
class EventTypeRequest extends BaseRequest implements IRequest
{
    /**
     * Event Type Request constructor.
     *
     * @param Authentication $authentication
     * @param Configuration $configuration
     */
    public function __construct($authentication, $configuration)
    {
        parent::__construct($authentication, $configuration, EventTypeResponse::class);
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
     * Get all event types
     * 
     * @param boolean $inUse If true, only events not older than 2 months will be returned.
     *
     * @return $this|\Twigger\UnionCloud\API\Response\IResponse|\Twigger\UnionCloud\API\ResourceCollection
     * 
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Twigger\UnionCloud\API\Exception\Request\RequestHistoryNotFound
     * @throws \Twigger\UnionCloud\API\Exception\Response\BaseResponseException
     */
    public function getAll($inUse = true)
    {
        $this->setAPIParameters(
            'event_types',
            'GET'
        );

        $this->addQueryParameter('in_use', ($inUse?'true':'false'));

        $this->enablePagination();
        $this->enableTimes();
        
        $this->call();
        
        return $this->getReturnDetails();
    }

}