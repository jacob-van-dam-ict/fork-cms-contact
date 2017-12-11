<?php

namespace Backend\Modules\Contact\Actions;

use Backend\Core\Engine\Base\ActionAdd as BackendBaseActionAdd;
use Backend\Core\Engine\Model as BackendModel;
use Backend\Core\Language\Locale;
use Backend\Modules\Contact\Domain\Contact\Command\UpdateContact;
use Backend\Modules\Contact\Domain\Contact\ContactType;
use Backend\Modules\Contact\Domain\ContactForm\ContactFormDataGrid;
use Symfony\Component\Form\Form;

/**
 * This is the index action makes it able to change contact data
 *
 * @author Jacob van Dam <j.vandam@jvdict.nl>
 */
class Index extends BackendBaseActionAdd
{
    /**
     * Execute the actions
     */
    public function execute(): void
    {
        parent::execute();

        $form = $this->getForm();
        if (!$form->isSubmitted() || ! $form->isValid()) {
            $this->template->assign('form', $form->createView());
            $this->template->assign('formDataGrid', ContactFormDataGrid::getHtml(Locale::workingLocale()));

            $this->parse();
            $this->display();

            return;
        }

        $this->updateContact($form);

        $this->redirect(
            $this->getBackLink(
                [
                    'report'  => 'edited'
                ]
            )
        );
    }

    private function updateContact(Form $form): UpdateContact
    {
        $updateContact = $form->getData();

        // The command bus will handle the saving of the category in the database.
        $this->get('command_bus')->handle($updateContact);

        return $updateContact;
    }

    private function getBackLink(array $parameters = []): string
    {
        return BackendModel::createUrlForAction(
            'Index',
            null,
            null,
            $parameters
        );
    }

    private function getForm(): Form
    {
        $form = $this->createForm(
            ContactType::class,
            new UpdateContact($this->get('fork.settings'))
        );

        $form->handleRequest($this->getRequest());

        return $form;
    }
}
