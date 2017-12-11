<?php

namespace Backend\Modules\Contact\Domain\ContactForm;

use Backend\Modules\Contact\Domain\ContactForm\Exception\ContactFormNotFound;
use Common\Locale;
use Doctrine\ORM\EntityRepository;

class ContactFormRepository extends EntityRepository
{
    public function add(ContactForm $contactForm): void
    {
        // We don't flush here, see http://disq.us/p/okjc6b
        $this->getEntityManager()->persist($contactForm);
    }

    public function findOneByIdAndLocale(?int $id, Locale $locale): ?ContactForm
    {
        if ($id === null) {
            throw ContactFormNotFound::forEmptyId();
        }

        /** @var ContactForm $contactForm */
        $contactForm = $this->findOneBy(['id' => $id, 'locale' => $locale]);

        if ($contactForm === null) {
            throw ContactFormNotFound::forId($id);
        }

        return $contactForm;
    }

    public function removeByIdAndLocale($id, Locale $locale): void
    {
        // We don't flush here, see http://disq.us/p/okjc6b
        array_map(
            function (ContactForm $contactForm) {
                $this->getEntityManager()->remove($contactForm);
            },
            (array) $this->findBy(['id' => $id, 'locale' => $locale])
        );
    }
}
