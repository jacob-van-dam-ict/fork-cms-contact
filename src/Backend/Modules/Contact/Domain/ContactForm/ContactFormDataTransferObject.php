<?php

namespace Backend\Modules\Contact\Domain\ContactForm;

use Backend\Core\Language\Locale;
use Symfony\Component\Validator\Constraints as Assert;

class ContactFormDataTransferObject
{
    /**
     * @var ContactForm
     */
    protected $contactFormEntity;

    /**
     * @var int
     */
    public $id;

    /**
     * @var int
     */
    public $extraId;

    /**
     * @var string
     *
     * @Assert\NotBlank(message="err.FieldIsRequired")
     */
    public $title;

    /**
     * @var string
     *
     * @Assert\NotBlank(message="err.FieldIsRequired")
     */
    public $text;

    /**
     * @var Image
     */
    public $background_image;

    /**
     * @var bool
     */
    public $show_title;

    /**
     * @var integer
     */
    public $form;

    /**
     * @var Locale
     */
    public $locale;

    public function __construct(ContactForm $contactForm = null)
    {
        $this->contactFormEntity = $contactForm;

        if ( ! $this->hasExistingContactForm()) {
            return;
        }

        $this->id               = $contactForm->getId();
        $this->extraId          = $contactForm->getExtraId();
        $this->title            = $contactForm->getTitle();
        $this->text             = $contactForm->getText();
        $this->locale           = $contactForm->getLocale();
        $this->form             = $contactForm->getForm();
        $this->background_image = $contactForm->getBackgroundImage();
        $this->show_title       = $contactForm->isShowTitle();
    }

    public function getContactFormEntity(): ContactForm
    {
        return $this->contactFormEntity;
    }

    public function hasExistingContactForm(): bool
    {
        return $this->contactFormEntity instanceof ContactForm;
    }
}
