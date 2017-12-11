<?php

namespace Backend\Modules\Contact\Actions;

use Backend\Core\Engine\Authentication;
use Backend\Core\Engine\Base\ActionAdd as BackendBaseActionAdd;
use Backend\Core\Engine\Model as BackendModel;
use Backend\Core\Language\Locale;
use Backend\Modules\Contact\Domain\ContactForm\Command\CreateContactForm;
use Backend\Modules\Contact\Domain\ContactForm\ContactFormType;
use Backend\Modules\Contact\Domain\ContactForm\Event\ContactFormCreated;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\Form;

class AddForm extends BackendBaseActionAdd
{
    public function execute(): void
    {
        parent::execute();

        $form = $this->getForm();

        if (!$form->isSubmitted() || !$form->isValid()) {
            $this->template->assign('form', $form->createView());

            $this->parse();
            $this->display();

            return;
        }

        $createContactForm = $this->createContactForm($form);

        $this->get('event_dispatcher')->dispatch(
            ContactFormCreated::EVENT_NAME,
            new ContactFormCreated($createContactForm->getContactFormEntity())
        );

        $this->redirect(
            $this->getBackLink(
                [
                    'report' => 'added',
                    'var' => $createContactForm->title,
                ]
            )
        );
    }

    private function createContactForm(Form $form): CreateContactForm
    {
        $createContactForm = $form->getData();

        // The command bus will handle the saving of the content block in the database.
        $this->get('command_bus')->handle($createContactForm);

        return $createContactForm;
    }

    private function getBackLink(array $parameters = []): string
    {
        return BackendModel::createUrlForAction(
            'Index',
            null,
            null,
            $parameters
        ) .'#tabForms';
    }

    private function getForm(): Form
    {
        $form = $this->createForm(
            ContactFormType::class,
            new CreateContactForm(),
            [
                'form_choices' => $this->getFormChoices()
            ]
        );

        $form->handleRequest($this->getRequest());

        return $form;
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
