<?php

namespace Backend\Modules\Contact\Actions;

use Backend\Core\Engine\Base\ActionDelete as BackendBaseActionDelete;
use Backend\Core\Engine\Model as BackendModel;
use Backend\Core\Language\Locale;
use Backend\Form\Type\DeleteType;
use Backend\Modules\Contact\Domain\ContactForm\ContactForm;
use Backend\Modules\Contact\Domain\ContactForm\Event\ContactFormDeleted;
use Backend\Modules\Contact\Domain\ContactForm\Exception\ContactFormNotFound;
use Backend\Modules\Contact\Domain\ContactForm\Command\DeleteContactForm;

/**
 * @author Jacob van Dam <j.vandam@jvdict.nl>
 */
class DeleteForm extends BackendBaseActionDelete
{
    /**
     * Execute the action
     */
    public function execute(): void
    {
        $deleteForm = $this->createForm(DeleteType::class, null, ['module' => $this->getModule()]);
        $deleteForm->handleRequest($this->getRequest());
        if ( ! $deleteForm->isSubmitted() || ! $deleteForm->isValid()) {
            $this->redirect($this->getBackLink(['error' => 'non-existing']));

            return;
        }
        $deleteFormData = $deleteForm->getData();

        $contactForm = $this->getContactForm((int)$deleteFormData['id']);

        // The command bus will handle the saving of the content block in the database.
        $this->get('command_bus')->handle(new DeleteContactForm($contactForm));

        $this->get('event_dispatcher')->dispatch(
            ContactFormDeleted::EVENT_NAME,
            new ContactFormDeleted($contactForm)
        );

        $this->redirect(
            $this->getBackLink(
                [
                    'report' => 'deleted',
                    'var'    => $contactForm->getTitle()
                ]
            )
        );
    }

    private function getBackLink(array $parameters = []): string
    {
        return BackendModel::createUrlForAction(
                'Index',
                null,
                null,
                $parameters
            ) . '#tabForms';
    }

    private function getContactForm(int $id): ContactForm
    {
        try {
            return $this->get('contact.repository.contact_form')->findOneByIdAndLocale(
                $id,
                Locale::workingLocale()
            );
        } catch (ContactFormNotFound $e) {
            $this->redirect($this->getBackLink(['error' => 'non-existing']));
        }
    }
}
