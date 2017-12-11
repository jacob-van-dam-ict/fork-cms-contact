<?php

namespace Backend\Modules\Contact\Domain\ContactForm\Command;

use Backend\Core\Engine\Model;
use Backend\Modules\Contact\Domain\ContactForm\ContactForm;
use Backend\Modules\Contact\Domain\ContactForm\ContactFormRepository;

final class DeleteContactFormHandler
{
    /** @var ContactFormRepository */
    private $contactFormRepository;

    public function __construct(ContactFormRepository $contactFormRepository)
    {
        $this->contactFormRepository = $contactFormRepository;
    }

    public function handle(DeleteContactForm $deleteContactForm): void
    {
        $this->contactFormRepository->removeByIdAndLocale(
            $deleteContactForm->contactForm->getId(),
            $deleteContactForm->contactForm->getLocale()
        );

        Model::deleteExtraById($deleteContactForm->contactForm->getExtraId());
    }
}
