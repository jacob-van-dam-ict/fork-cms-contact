<?php

namespace Backend\Modules\Contact\Domain\ContactForm\Exception;

use Exception;

class ContactFormNotFound extends Exception
{
    public static function forEmptyId(): self
    {
        return new self('The id you have given is null');
    }

    public static function forEmptyRevisionId(): self
    {
        return new self('The revision-id you have given is null');
    }

    public static function forId(string $id): self
    {
        return new self('Can\'t find a ContactForm with id = "' . $id . '".');
    }

    public static function forRevisionId(string $id): self
    {
        return new self('Can\'t find a ContactForm with revision-id = "' . $id . '".');
    }
}
