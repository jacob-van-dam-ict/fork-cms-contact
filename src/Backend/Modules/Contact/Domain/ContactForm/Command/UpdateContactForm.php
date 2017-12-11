<?php

namespace Backend\Modules\Contact\Domain\ContactForm\Command;

use Backend\Modules\Contact\Domain\ContactForm\ContactForm;
use Backend\Modules\Contact\Domain\ContactForm\ContactFormDataTransferObject;

final class UpdateContactForm extends ContactFormDataTransferObject
{
    public function __construct(ContactForm $contactForm)
    {
        parent::__construct($contactForm);
    }

    public function setContactFormEntity(ContactForm $contactFormEntity): void
    {
        $this->contactFormEntity = $contactFormEntity;
    }
}
