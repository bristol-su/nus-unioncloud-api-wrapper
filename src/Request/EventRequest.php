<?php
/**
 * Event Request class
 */
namespace Twigger\UnionCloud\API\Request;


use Twigger\UnionCloud\API\Auth\Authentication;
use Twigger\UnionCloud\API\Configuration;
use Twigger\UnionCloud\API\Response\EventResponse;

/**
 * Class Event Request
 *
 * @package Twigger\UnionCloud\API\Events\Events
 *
 * @license    https://opensource.org/licenses/GPL-3.0  GNU Public License v3
 *
 * @author     Toby Twigger <tt15951@bristol.ac.uk>
 *
 */
class EventRequest extends BaseRequest implements IRequest
{
    /**
     * Event Request constructor.
     *
     * @param Authentication $authentication
     * @param Configuration $configuration
     */
    public function __construct($authentication, $configuration)
    {
        parent::__construct($authentication, $configuration, EventResponse::class);
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
     * Create an Event
     * 
     * @param mixed[] $event Event parameters
     * 
     * @return $this|\Twigger\UnionCloud\API\Response\IResponse|\Twigger\UnionCloud\API\ResourceCollection
     * 
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Twigger\UnionCloud\API\Exception\Request\RequestHistoryNotFound
     * @throws \Twigger\UnionCloud\API\Exception\Response\BaseResponseException
     */
    public function create($event)
    {
        $this->setAPIParameters(
            'events',
            'POST',
            $event
        );
        $this->setContentType('application/json');

        $this->call();
        
        return $this->getReturnDetails();
    }

    /**
     * Update an Event
     *
     * @param integer $eventID ID of the event to update
     * @param mixed[] $event Details of the event to update
     *
     * @return $this|\Twigger\UnionCloud\API\Response\IResponse|\Twigger\UnionCloud\API\ResourceCollection
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Twigger\UnionCloud\API\Exception\Request\RequestHistoryNotFound
     * @throws \Twigger\UnionCloud\API\Exception\Response\BaseResponseException
     */
    public function update($eventID, $event)
    {
        $this->setAPIParameters(
            'events/'.$eventID,
            'PUT',
            $event
        );

        $this->call();

        return $this->getReturnDetails();
    }

    /**
     * Cancel an Event
     *
     * @param integer $eventID ID of the event to update
     *
     * @return $this|\Twigger\UnionCloud\API\Response\IResponse|\Twigger\UnionCloud\API\ResourceCollection
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Twigger\UnionCloud\API\Exception\Request\RequestHistoryNotFound
     * @throws \Twigger\UnionCloud\API\Exception\Response\BaseResponseException
     */
    public function cancel($eventID)
    {
        $this->setAPIParameters(
            'events/'.$eventID.'/cancel',
            'PUT'
        );

        $this->call();

        return $this->getReturnDetails();
    }

    /**
     * Get all Events in the Union
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
            'events',
            'GET'
        );

        $this->enableMode();
        $this->enablePagination();
        $this->enableTimes();

        $this->call();

        return $this->getReturnDetails();
    }

    /**
     * Get a specific Event
     *
     * @param integer $eventID ID of the Event
     *
     * @return $this|\Twigger\UnionCloud\API\Response\IResponse|\Twigger\UnionCloud\API\ResourceCollection
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Twigger\UnionCloud\API\Exception\Request\RequestHistoryNotFound
     * @throws \Twigger\UnionCloud\API\Exception\Response\BaseResponseException
     */
    public function getByID($eventID)
    {
        $this->setAPIParameters(
            'events/'.$eventID,
            'GET'
        );

        $this->enableMode();

        $this->call();

        return $this->getReturnDetails();
    }

    /**
     * Search for an Event
     *
     * @param mixed[] $searchParameters Associative array of search parameters
     *
     * @return $this|\Twigger\UnionCloud\API\Response\IResponse|\Twigger\UnionCloud\API\ResourceCollection
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Twigger\UnionCloud\API\Exception\Request\RequestHistoryNotFound
     * @throws \Twigger\UnionCloud\API\Exception\Response\BaseResponseException
     */
    public function search($searchParameters)
    {
        $this->setAPIParameters(
            'events/search',
            'POST',
            $searchParameters
        );

        $this->enableMode();
        $this->enablePagination();

        $this->call();

        return $this->getReturnDetails();
    }


}
