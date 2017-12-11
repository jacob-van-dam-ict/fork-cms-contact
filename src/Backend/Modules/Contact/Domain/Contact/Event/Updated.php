<?php

namespace Backend\Modules\Contact\Domain\Contact\Event;

final class Updated extends Event
{
    /**
     * @var string The name the listener needs to listen to to catch this event.
     */
    const EVENT_NAME = 'contact.event.contact.updated';
}
