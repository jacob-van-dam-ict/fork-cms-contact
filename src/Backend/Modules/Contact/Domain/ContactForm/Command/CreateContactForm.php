<?php

namespace Backend\Modules\Contact\Domain\ContactForm\Command;

use Backend\Core\Language\Locale;
use Backend\Modules\Contact\Domain\ContactForm\ContactForm;
use Backend\Modules\Contact\Domain\ContactForm\ContactFormDataTransferObject;

final class CreateContactForm extends ContactFormDataTransferObject
{
    public function __construct(Locale $locale = null)
    {
        parent::__construct();

        if ($locale === null) {
            $locale = Locale::workingLocale();
        }

        $this->locale = $locale;
    }

    public function setContactFormEntity(ContactForm $contactFormEntity): void
    {
        $this->contactFormEntity = $contactFormEntity;
    }
}
