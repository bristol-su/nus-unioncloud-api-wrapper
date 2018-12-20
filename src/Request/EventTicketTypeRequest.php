<?php
/**
 * Event Ticket Type Request class
 */
namespace Twigger\UnionCloud\API\Request;


use Twigger\UnionCloud\API\Auth\Authentication;
use Twigger\UnionCloud\API\Configuration;
use Twigger\UnionCloud\API\Response\EventTicketResponse;
use Twigger\UnionCloud\API\Response\EventTicketTypeResponse;

/**
 * Class Event Ticket Type Request
 *
 * @package Twigger\UnionCloud\API\Events\EventTicketTypes
 *
 * @license    https://opensource.org/licenses/GPL-3.0  GNU Public License v3
 *
 * @author     Toby Twigger <tt15951@bristol.ac.uk>
 *
 */
class EventTicketTypeRequest extends BaseRequest implements IRequest
{
    /**
     * Event Ticket Types Request constructor.
     *
     * @param Authentication $authentication
     * @param Configuration $configuration
     */
    public function __construct($authentication, $configuration)
    {
        parent::__construct($authentication, $configuration, EventTicketTypeResponse::class);
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
     * Create a new Event Ticket Type
     *
     * @param integer $eventID ID of the event to create the ticket type for
     * @param mixed[] $ticketData Data to construct the Ticket Type
     *
     * @return $this|\Twigger\UnionCloud\API\Response\IResponse|\Twigger\UnionCloud\API\ResourceCollection
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Twigger\UnionCloud\API\Exception\Request\RequestHistoryNotFound
     * @throws \Twigger\UnionCloud\API\Exception\Response\BaseResponseException
     */
    public function create($eventID, $ticketData)
    {
        $this->setAPIParameters(
            'events/'.$eventID.'/event_ticket_types',
            'POST',
            $ticketData
        );

        $this->call();

        return $this->getReturnDetails();
    }

    /**
     * Update an Event Ticket Type
     *
     * @param integer $eventID ID of the event
     * @param integer $eventTicketTypeID ID of the event ticket type
     * @param mixed[] $ticketData Data of the ticket to update
     *
     * @return $this|\Twigger\UnionCloud\API\Response\IResponse|\Twigger\UnionCloud\API\ResourceCollection
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Twigger\UnionCloud\API\Exception\Request\RequestHistoryNotFound
     * @throws \Twigger\UnionCloud\API\Exception\Response\BaseResponseException
     */
    public function update($eventID, $eventTicketTypeID, $ticketData)
    {
        $this->setAPIParameters(
            'events/'.$eventID.'/event_ticket_types/'.$eventTicketTypeID,
            'PUT',
            $ticketData
        );

        $this->call();

        return $this->getReturnDetails();
    }

    /**
     * Delete an Event Ticket Type
     *
     * @param integer $eventID ID of the event
     * @param integer $eventTicketTypeID ID of the event ticket type
     *
     * @return $this|\Twigger\UnionCloud\API\Response\IResponse|\Twigger\UnionCloud\API\ResourceCollection
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Twigger\UnionCloud\API\Exception\Request\RequestHistoryNotFound
     * @throws \Twigger\UnionCloud\API\Exception\Response\BaseResponseException
     */
    public function delete($eventID, $eventTicketTypeID)
    {
        $this->setAPIParameters(
            'events/'.$eventID.'/event_ticket_types/'.$eventTicketTypeID,
            'DELETE'
        );

        $this->call();

        return $this->getReturnDetails();
    }
}