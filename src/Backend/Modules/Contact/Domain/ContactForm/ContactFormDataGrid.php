<?php

namespace Backend\Modules\Contact\Domain\ContactForm;

use Backend\Core\Engine\DataGridDatabase;
use Backend\Core\Engine\Authentication as BackendAuthentication;
use Backend\Core\Engine\Model;
use Backend\Core\Language\Language;
use Backend\Core\Language\Locale;
use Doctrine\ORM\EntityManager;

/**
 * @TODO replace with a doctrine implementation of the data grid
 */
class ContactFormDataGrid extends DataGridDatabase
{
    public function __construct(Locale $locale)
    {
        parent::__construct(
            'SELECT i.id, i.title, i.form_id
             FROM contact_forms AS i
             WHERE i.language = :language',
            ['language' => $locale]
        );

        $this->setSortingColumns(['title']);
        $this->setHeaderLabels(['form_id' => ucfirst(Language::lbl('Form'))]);
        $this->setColumnFunction([self::class, 'getFormName'], ['[form_id]'], 'form_id');

        // check if this action is allowed
        if (BackendAuthentication::isAllowedAction('EditForm')) {
            $editUrl = Model::createUrlForAction('EditForm', null, null, ['id' => '[id]'], false);
            $this->setColumnURL('title', $editUrl);
            $this->addColumn('edit', null, Language::lbl('Edit'), $editUrl, Language::lbl('Edit'));
        }
    }

    public static function getHtml(Locale $locale): string
    {
        return (new self($locale))->getContent();
    }

    public static function getFormName(?int $id): string
    {
        if (!$id) {
            return '';
        }

        /**
         * @var EntityManager $em
         */
        $em = Model::get('doctrine.orm.entity_manager');
        $query = $em->getConnection()->prepare('SELECT name FROM forms WHERE language = :locale ORDER BY name ASC');
        $query->bindValue('locale', Locale::workingLocale());
        $query->execute();

        return $query->fetchColumn();
    }
}
