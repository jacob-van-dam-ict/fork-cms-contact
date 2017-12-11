<?php

namespace Backend\Modules\Contact\Domain\Contact\Event;

use Backend\Modules\Services\Domain\Service\Service;
use Symfony\Component\EventDispatcher\Event as EventDispatcher;

abstract class Event extends EventDispatcher
{
}
