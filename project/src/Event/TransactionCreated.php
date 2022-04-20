<?php

namespace App\Event;

use Symfony\Contracts\EventDispatcher\Event;

class TransactionCreated extends Event
{
    public const NAME = 'transaction.created';
}