<?php
/**
 * Event Ticket Request class
 */
namespace Twigger\UnionCloud\API\Request;


use Twigger\UnionCloud\API\Auth\Authentication;
use Twigger\UnionCloud\API\Configuration;
use Twigger\UnionCloud\API\Response\EventTicketResponse;

/**
 * Class Event Ticket Request
 *
 * @package Twigger\UnionCloud\API\Events\EventTicketTypes
 *
 * @license    https://opensource.org/licenses/GPL-3.0  GNU Public License v3
 *
 * @author     Toby Twigger <tt15951@bristol.ac.uk>
 *
 */
class EventTicketRequest extends BaseRequest implements IRequest
{
    /**
     * Event Ticket Request constructor.
     *
     * @param Authentication $authentication
     * @param Configuration $configuration
     */
    public function __construct($authentication, $configuration)
    {
        parent::__construct($authentication, $configuration, EventTicketResponse::class);
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
     * Get all event tickets belonging to a user
     *
     * @param int $uid User ID of the user
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
            'users/'.$uid.'/tickets',
            'GET'
        );

        $this->enableMode();
        $this->enablePagination();

        $this->call();

        return $this->getReturnDetails();
    }

    /**
     * Redeem a ticket from a user
     *
     * @param int $eventID ID of the event
     * @param string $ticketNo Ticket number
     *
     * @return $this|\Twigger\UnionCloud\API\Response\IResponse|\Twigger\UnionCloud\API\ResourceCollection
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Twigger\UnionCloud\API\Exception\Request\RequestHistoryNotFound
     * @throws \Twigger\UnionCloud\API\Exception\Response\BaseResponseException
     */
    public function redeem($eventID, $ticketNo)
    {
        $this->setAPIParameters(
            'events/'.$eventID.'/ticket_redemption',
            'POST',
            [
                'ticket_number' => $ticketNo
            ]
        );

        $this->call();

        return $this->getReturnDetails();
    }
}