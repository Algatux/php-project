<?php

namespace App\EventListener;

use App\Event\TransactionCreated;

class TransactionListener
{
    public function onTransactionCreated(TransactionCreated $event): void
    {
        dump($event);
    }
}