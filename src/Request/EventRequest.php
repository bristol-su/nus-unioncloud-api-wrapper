<?php

namespace Twigger\UnionCloud\Request;

/**
 * @package    UnionCloud
 * @license    https://opensource.org/licenses/GPL-3.0  GNU Public License v3
 * @author     Toby Twigger <tt15951@bristol.ac.uk>
 */
class EventRequest extends BaseRequest
{

    public function __construct($authentication)
    {
        parent::__construct($authentication);
    }

    /**
     * Get event by Event ID
     *
     * @param int $eventID Event ID
     */
    public function getByID($eventID)
    {

        $this->call();

        return $this->getRawData();
    }

}