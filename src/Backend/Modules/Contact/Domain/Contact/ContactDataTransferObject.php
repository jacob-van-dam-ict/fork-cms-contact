<?php

namespace Backend\Modules\Contact\Domain\Contact;

use Common\ModulesSettings;
use Symfony\Component\Validator\Constraints as Assert;

class ContactDataTransferObject
{
    /**
     * @var string
     */
    public $street;

    /**
     * @var string
     */
    public $number;

    /**
     * @var string
     */
    public $zip_code;

    /**
     * @var string
     */
    public $city;

    /**
     * @var string
     *
     * @Assert\Email(message="err.EmailIsInvalid")
     */
    public $email;

    /**
     * @var string
     */
    public $phone;

    /**
     * @var string
     *
     * @Assert\Url(message="err.InvalidURL")
     */
    public $facebook;

    /**
     * @var string
     *
     * @Assert\Url(message="err.InvalidURL")
     */
    public $twitter;

    /**
     * @var string
     *
     * @Assert\Url(message="err.InvalidURL")
     */
    public $linked_in;

    /**
     * @var string
     *
     * @Assert\Url(message="err.InvalidURL")
     */
    public $google_plus;

    /**
     * @var string
     *
     * @Assert\Url(message="err.InvalidURL")
     */
    public $pinterest;

    /**
     * @var string
     *
     * @Assert\Url(message="err.InvalidURL")
     */
    public $instagram;

    /**
     * @var string
     *
     * @Assert\Url(message="err.InvalidURL")
     */
    public $youtube;

    /**
     * @var string
     */
    public $google_maps_key;

    public $module = 'Contact';

    private $socialUrls = [];

    /**
     * ContactDataTransferObject constructor.
     *
     * @param ModulesSettings $settings
     */
    public function __construct(ModulesSettings $settings)
    {
        $this->street          = $settings->get($this->module, 'street');
        $this->number          = $settings->get($this->module, 'number');
        $this->zip_code        = $settings->get($this->module, 'zip_code');
        $this->city            = $settings->get($this->module, 'city');
        $this->email           = $settings->get($this->module, 'email');
        $this->phone           = $settings->get($this->module, 'phone');
        $this->google_maps_key = $settings->get($this->module, 'google_maps_key');

        $this->setFacebook($settings->get($this->module, 'facebook'));
        $this->setTwitter($settings->get($this->module, 'twitter'));
        $this->setLinkedIn($settings->get($this->module, 'linked_id'));
        $this->setGooglePlus($settings->get($this->module, 'google_plus'));
        $this->setPinterest($settings->get($this->module, 'pinterest'));
        $this->setInstagram($settings->get($this->module, 'instagram'));
        $this->setYoutube($settings->get($this->module, 'youtube'));
    }

    public function setFacebook(?string $facebook)
    {
        $this->facebook = $facebook;

        if ($facebook) {
            $this->socialUrls['facebook'] = $facebook;
        }
    }

    /**
     * @param string $twitter
     */
    public function setTwitter(?string $twitter)
    {
        $this->twitter = $twitter;

        if ($twitter) {
            $this->socialUrls['twitter'] = $twitter;
        }
    }

    /**
     * @param string $linked_in
     */
    public function setLinkedIn(?string $linked_in)
    {
        $this->linked_in = $linked_in;

        if ($linked_in) {
            $this->socialUrls['linked-in'] = $linked_in;
        }
    }

    /**
     * @param string $google_plus
     */
    public function setGooglePlus(?string $google_plus)
    {
        $this->google_plus = $google_plus;

        if ($google_plus) {
            $this->socialUrls['google-plus'] = $google_plus;
        }
    }

    /**
     * @param string $pinterest
     */
    public function setPinterest(?string $pinterest)
    {
        $this->pinterest = $pinterest;

        if ($pinterest) {
            $this->socialUrls['pinterest'] = $pinterest;
        }
    }

    /**
     * @param string $instagram
     */
    public function setInstagram(?string $instagram)
    {
        $this->instagram = $instagram;

        if ($instagram) {
            $this->socialUrls['instagram'] = $instagram;
        }
    }

    /**
     * @param string $youtube
     */
    public function setYoutube(?string $youtube)
    {
        $this->youtube = $youtube;

        if ($youtube) {
            $this->socialUrls['youtube'] = $youtube;
        }
    }

    /**
     * Get all the social urls in an array
     *
     * @return array
     */
    public function getSocialUrls(): array
    {
        return $this->socialUrls;
    }
}
