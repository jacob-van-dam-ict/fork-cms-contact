<?php

namespace Backend\Modules\Contact\Domain\ContactForm;

use Backend\Core\Engine\Model;
use Common\Locale;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="contact_forms")
 * @ORM\Entity(repositoryClass="ContactFormRepository")
 * @ORM\HasLifecycleCallbacks
 */
class ContactForm
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", name="extra_id")
     */
    private $extraId;

    /**
     * @var Locale
     *
     * @ORM\Column(type="locale", name="language")
     */
    private $locale;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     */
    private $text;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer", name="form_id", nullable=true)
     */
    private $form;

    /**
     * @var Image
     *
     * @ORM\Column(type="contact_contact_form_image_type", nullable=true)
     */
    private $background_image;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", options={"default" = false})
     */
    private $show_title;

    /**
     * @var DateTime
     *
     * @ORM\Column(type="datetime", name="created_on")
     */
    private $createdOn;

    /**
     * @var DateTime
     *
     * @ORM\Column(type="datetime", name="edited_on")
     */
    private $editedOn;

    private function __construct(
        int $extraId,
        Locale $locale,
        string $title,
        string $text,
        ?int $form,
        ?Image $background_image,
        bool $show_title
    ) {
        $this->extraId          = $extraId;
        $this->locale           = $locale;
        $this->title            = $title;
        $this->text             = $text;
        $this->form             = $form;
        $this->background_image = $background_image;
        $this->show_title       = $show_title;
    }

    public static function fromDataTransferObject(ContactFormDataTransferObject $dataTransferObject): self
    {
        if ($dataTransferObject->hasExistingContactForm()) {
            return self::update($dataTransferObject);
        }

        return self::create($dataTransferObject);
    }

    private static function create(ContactFormDataTransferObject $dataTransferObject): self
    {
        return new self(
            $dataTransferObject->extraId,
            $dataTransferObject->locale,
            $dataTransferObject->title,
            $dataTransferObject->text,
            $dataTransferObject->form,
            $dataTransferObject->background_image,
            $dataTransferObject->show_title
        );
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getExtraId(): int
    {
        return $this->extraId;
    }

    public function getLocale(): Locale
    {
        return $this->locale;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @return int
     */
    public function getForm(): int
    {
        return $this->form;
    }

    /**
     * @return Image
     */
    public function getBackgroundImage(): ?Image
    {
        return $this->background_image;
    }

    /**
     * @ORM\PrePersist()
     */
    public function prepareToUploadImage()
    {
        $this->background_image->prepareToUpload();
    }

    /**
     * @ORM\PostPersist()
     */
    public function uploadImage()
    {
        $this->background_image->upload();
    }

    /**
     * @ORM\PostRemove()
     */
    public function postRemove()
    {
        $this->background_image->remove();
    }

    /**
     * @return bool
     */
    public function isShowTitle(): bool
    {
        return $this->show_title;
    }

    public function getCreatedOn(): DateTime
    {
        return $this->createdOn;
    }

    public function getEditedOn(): DateTime
    {
        return $this->editedOn;
    }

    /**
     * @ORM\PrePersist
     */
    public function prePersist()
    {
        $this->editedOn = new DateTime();

        if ( ! $this->id) {
            $this->createdOn = $this->editedOn;
        }
    }

    /**
     * @ORM\PostPersist
     */
    public function postPersist()
    {
        $this->updateWidget();
    }

    private static function update(ContactFormDataTransferObject $dataTransferObject): self
    {
        $contactForm = $dataTransferObject->getContactFormEntity();

        $contactForm->extraId          = $dataTransferObject->extraId;
        $contactForm->locale           = $dataTransferObject->locale;
        $contactForm->title            = $dataTransferObject->title;
        $contactForm->text             = $dataTransferObject->text;
        $contactForm->form             = $dataTransferObject->form;
        $contactForm->background_image = $dataTransferObject->background_image;
        $contactForm->show_title       = $dataTransferObject->show_title;

        return $contactForm;
    }

    /**
     * Update the widget so it shows the correct title and has the correct template
     */
    private function updateWidget()
    {
        $editUrl = Model::createUrlForAction('EditForm', 'Contact', (string)$this->locale) . '&id=' . $this->id;

        // update data for the extra
        // @TODO replace this with an implementation with doctrine
        $extras = Model::getExtras([$this->extraId]);
        $extra  = reset($extras);
        $data   = [
            'id'       => $this->id,
            'language' => (string)$this->locale,
            'edit_url' => $editUrl,
        ];
        if (isset($extra['data'])) {
            $data = $data + (array)$extra['data'];
        }
        $data['extra_label'] = $this->title;

        Model::updateExtra($this->extraId, 'data', $data);
    }

    public function getDataTransferObject(): ContactFormDataTransferObject
    {
        return new ContactFormDataTransferObject($this);
    }
}
