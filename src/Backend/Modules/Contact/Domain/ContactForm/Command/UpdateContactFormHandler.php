<?php

namespace Backend\Modules\Contact\Domain\ContactForm\Command;

use Backend\Modules\Contact\Domain\ContactForm\ContactForm;
use Backend\Modules\Contact\Domain\ContactForm\ContactFormRepository;

final class UpdateContactFormHandler
{
    /** @var ContactFormRepository */
    private $contactFormRepository;

    public function __construct(ContactFormRepository $contactFormRepository)
    {
        $this->contactFormRepository = $contactFormRepository;
    }

    public function handle(UpdateContactForm $updateContactForm): void
    {
        $contactForm = ContactForm::fromDataTransferObject($updateContactForm);
        $this->contactFormRepository->add($contactForm);

        $updateContactForm->setContactFormEntity($contactForm);
    }
}
