<?php

namespace Frontend\Modules\Contact\Widgets;

use Backend\Modules\Contact\Domain\Contact\ContactDataTransferObject;
use Backend\Modules\Slider\Domain\Category\Category;
use Frontend\Core\Engine\Base\Widget as FrontendBaseWidget;
use Frontend\Core\Language\Locale;

/**
 * @author Jacob van Dam <j.vandam@jvdict.nl>
 */
class ContactForm extends FrontendBaseWidget
{
    /**
     * Execute the extra.
     */
    public function execute(): void
    {
        parent::execute();

        $this->loadTemplate();

        $contactFormRepository = $this->get('contact.repository.contact_form');

        $this->template->assign(
            'contactForm',
            $contactFormRepository->findOneByIdAndLocale(
                $this->data['id'],
                Locale::frontendLanguage()
            )
        );
    }
}
