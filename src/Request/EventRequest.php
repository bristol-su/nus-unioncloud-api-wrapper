<?php

namespace Twigger\UnionCloud\Request;

use Twigger\UnionCloud\Response\EventResponse;

/**
 * @package    UnionCloud
 * @license    https://opensource.org/licenses/GPL-3.0  GNU Public License v3
 * @author     Toby Twigger <tt15951@bristol.ac.uk>
 */
class EventRequest extends BaseRequest implements IRequest
{

    public function __construct($authentication, $configuration)
    {
        parent::__construct($authentication, $configuration);
    }

    /**
     * Get event by Event ID
     *
     * @param int $eventID Event ID
     */
    public function getByID($eventID)
    {
        // Set API parameters
        $this->setAPIParameters(
            'events/'.$eventID,
            'GET',
            EventResponse::class
        );

        // Make an API request
        $this->call();

        // Create resources
        $resources = $this->processResponse(EventResponse::class);

        return $resources;
    }

}