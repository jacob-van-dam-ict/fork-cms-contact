<?php

namespace Backend\Modules\Contact\Actions;

use Backend\Core\Engine\Base\ActionEdit as BackendBaseActionEdit;
use Backend\Core\Engine\Model as BackendModel;
use Backend\Core\Language\Locale;
use Backend\Form\Type\DeleteType;
use Backend\Modules\Contact\Domain\ContactForm\Command\UpdateContactForm;
use Backend\Modules\Contact\Domain\ContactForm\ContactForm;
use Backend\Modules\Contact\Domain\ContactForm\ContactFormType;
use Backend\Modules\Contact\Domain\ContactForm\Event\ContactFormUpdated;
use Backend\Modules\Contact\Domain\ContactForm\Exception\ContactFormNotFound;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\Form;

/**
 * @author Jacob van Dam <j.vandam@jvdict.nl>
 */
class EditForm extends BackendBaseActionEdit
{
    /**
     * @var ContactForm
     */
    private $contactForm;

    /**
     * Execute the action
     */
    public function execute(): void
    {
        parent::execute();

        $this->exists();

        $form = $this->getForm($this->contactForm);

        $deleteForm = $this->createForm(
            DeleteType::class,
            ['id' => $this->contactForm->getId()],
            [
                'module' => $this->getModule(),
                'action' => 'DeleteForm'
            ]
        );

        $this->template->assign('deleteForm', $deleteForm->createView());

        if ( ! $form->isSubmitted() || ! $form->isValid()) {
            $this->template->assign('form', $form->createView());
            $this->template->assign('contactForm', $this->contactForm);

            $this->parse();
            $this->display();

            return;
        }

        /** @var UpdateContactForm $updateContactForm */
        $updateContactForm = $this->updateContactForm($form);

        $this->get('event_dispatcher')->dispatch(
            ContactFormUpdated::EVENT_NAME,
            new ContactFormUpdated($updateContactForm->getContactFormEntity())
        );

        $this->redirect(
            $this->getBackLink(
                [
                    'report'    => 'edited',
                    'var'       => $updateContactForm->title,
                    'highlight' => 'row-' . $updateContactForm->getContactFormEntity()->getId(),
                ]
            ) . '#tabSlides'
        );
    }

    private function getBackLink(array $parameters = []): string
    {
        return BackendModel::createUrlForAction(
            'Index',
            null,
            null,
            $parameters
        ).'#tabForms';
    }

    private function getForm(ContactForm $contactForm): Form
    {
        $form = $this->createForm(
            ContactFormType::class,
            new UpdateContactForm($contactForm),
            [
                'form_choices' => $this->getFormChoices()
            ]
        );

        $form->handleRequest($this->getRequest());

        return $form;
    }

    private function updateContactForm(Form $form): UpdateContactForm
    {
        /** @var UpdateContactForm $updateContactForm */
        $updateContactForm = $form->getData();

        // The command bus will handle the saving of the slide in the database.
        $this->get('command_bus')->handle($updateContactForm);

        return $updateContactForm;
    }

    private function exists(): void
    {
        // get parameters
        $this->id = (int)$this->getRequest()->query->get('id', null);

        $contactFormRepository = $this->get('contact.repository.contact_form');

        // does the item exists
        if ($this->id) {
            try {
                $this->contactForm = $contactFormRepository->findOneByIdAndLocale($this->id, Locale::workingLocale());
            } catch (ContactFormNotFound $e) {
                $this->redirect($this->getBackLink());

                return;
            }
        }
    }

    private function getFormChoices(): array
    {
        /**
         * @var EntityManager $em
         */
        $em = $this->get('doctrine.orm.entity_manager');
        $query = $em->getConnection()->prepare('SELECT name, id FROM forms WHERE language = :locale ORDER BY name ASC');
        $query->bindValue('locale', Locale::workingLocale());
        $query->execute();

        return $query->fetchAll(\PDO::FETCH_KEY_PAIR);
    }
}
