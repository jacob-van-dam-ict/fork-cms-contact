<?php

namespace Backend\Modules\Contact\Domain\ContactForm\Command;

use Backend\Core\Engine\Model;
use Backend\Modules\Contact\Domain\ContactForm\ContactForm;
use Backend\Modules\Contact\Domain\ContactForm\ContactFormRepository;
use Common\ModuleExtraType;

final class CreateContactFormHandler
{
    /** @var ContactFormRepository */
    private $contactFormRepository;

    public function __construct(ContactFormRepository $contactFormRepository)
    {
        $this->contactFormRepository = $contactFormRepository;
    }

    public function handle(CreateContactForm $createContactForm): void
    {
        $createContactForm->extraId = $this->getNewExtraId();

        $contactForm = ContactForm::fromDataTransferObject($createContactForm);
        $this->contactFormRepository->add($contactForm);

        $createContactForm->setContactFormEntity($contactForm);
    }

    private function getNewExtraId(): int
    {
        return Model::insertExtra(
            ModuleExtraType::widget(),
            'Contact',
            'ContactForm'
        );
    }
}
