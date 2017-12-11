<?php

namespace Backend\Modules\Contact\Domain\ContactForm\Command;

use Backend\Modules\Contact\Domain\ContactForm\ContactForm;

final class DeleteContactForm
{
    /** @var ContactForm */
    public $contactForm;

    public function __construct(ContactForm $contactForm)
    {
        $this->contactForm = $contactForm;
    }
}
