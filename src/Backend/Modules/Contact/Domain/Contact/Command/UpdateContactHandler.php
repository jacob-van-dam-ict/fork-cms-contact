<?php

namespace Backend\Modules\Contact\Domain\Contact\Command;

use Common\ModulesSettings;

final class UpdateContactHandler
{
    /** @var ModulesSettings */
    private $settings;

    public function __construct(ModulesSettings $settings)
    {
        $this->settings = $settings;
    }

    public function handle(UpdateContact $updateContact): void
    {
        $this->settings->set($updateContact->module, 'street', $updateContact->street);
        $this->settings->set($updateContact->module, 'number', $updateContact->number);
        $this->settings->set($updateContact->module, 'zip_code', $updateContact->zip_code);
        $this->settings->set($updateContact->module, 'city', $updateContact->city);
        $this->settings->set($updateContact->module, 'email', $updateContact->email);
        $this->settings->set($updateContact->module, 'phone', $updateContact->phone);
        $this->settings->set($updateContact->module, 'facebook', $updateContact->facebook);
        $this->settings->set($updateContact->module, 'twitter', $updateContact->twitter);
        $this->settings->set($updateContact->module, 'linked_in', $updateContact->linked_in);
        $this->settings->set($updateContact->module, 'google_plus', $updateContact->google_plus);
        $this->settings->set($updateContact->module, 'pinterest', $updateContact->pinterest);
        $this->settings->set($updateContact->module, 'instagram', $updateContact->instagram);
        $this->settings->set($updateContact->module, 'youtube', $updateContact->youtube);
        $this->settings->set($updateContact->module, 'google_maps_key', $updateContact->google_maps_key);
    }
}
