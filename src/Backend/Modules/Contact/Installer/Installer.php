<?php

namespace Backend\Modules\Contact\Installer;

use Backend\Core\Engine\Model;
use Backend\Core\Installer\ModuleInstaller;
use Backend\Modules\Contact\Domain\ContactForm\ContactForm;
use Common\ModuleExtraType;

/**
 * Installer for the Contacts module
 *
 * @author Jacob van Dam (Jacob van Dam ICT) <j.vandam@jvdict.nl>
 */
class Installer extends ModuleInstaller
{
    public function install()
    {
        $this->configureEntities();

        // add 'contacts' as a module
        $this->addModule('Contact');

        // import locale
        $this->importLocale(dirname(__FILE__) . '/Data/Locale.xml');

        // module rights
        $this->setModuleRights(1, 'Contact');

        // Contacts and index
        $this->setActionRights(1, 'Contact', 'Index');
        $this->setActionRights(1, 'Contact', 'AddForm');
        $this->setActionRights(1, 'Contact', 'EditForm');
        $this->setActionRights(1, 'Contact', 'DeleteForm');

        // add extra's
        $this->insertExtra('Contact', ModuleExtraType::widget(), 'GetInTouchBig', 'GetInTouchBig');
        $this->insertExtra('Contact', ModuleExtraType::widget(), 'GetInTouch', 'GetInTouch');

        // set navigation
        $navigationModulesId = $this->setNavigation(null, 'Modules');
        $this->setNavigation(
            $navigationModulesId,
            'Contact',
            'contact/index',
            ['contact/add_form', 'contact/edit_form']
        );
    }

    private function configureEntities(): void
    {
        Model::get('fork.entity.create_schema')->forEntityClass(ContactForm::class);
    }
}
