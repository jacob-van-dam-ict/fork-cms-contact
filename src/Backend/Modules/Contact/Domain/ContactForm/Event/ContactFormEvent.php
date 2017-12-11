<?php

namespace Backend\Modules\Contact\Domain\ContactForm\Event;

use Backend\Modules\Contact\Domain\ContactForm\ContactForm;
use Symfony\Component\EventDispatcher\Event;

abstract class ContactFormEvent extends Event
{
    /** @var ContactForm */
    private $contactForm;

    public function __construct(ContactForm $contactForm)
    {
        $this->contactForm = $contactForm;
    }

    public function getContactForm(): ContactForm
    {
        return $this->contactForm;
    }
}
