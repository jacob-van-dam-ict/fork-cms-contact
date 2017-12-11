<?php

namespace Backend\Modules\Contact\Domain\ContactForm\Event;

final class ContactFormUpdated extends ContactFormEvent
{
    /**
     * @var string The name the listener needs to listen to to catch this event.
     */
    const EVENT_NAME = 'contact.event.contact_form_updated';
}
