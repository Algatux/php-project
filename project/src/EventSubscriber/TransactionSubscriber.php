<?php declare(strict_types=1);

namespace App\EventSubscriber;

use App\Event\TransactionCreated;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class TransactionSubscriber implements EventSubscriberInterface
{
    public function onTransactionCreated($event)
    {
        dump($event);
    }

    public static function getSubscribedEvents()
    {
        return [
            TransactionCreated::class => 'onTransactionCreated',
        ];
    }
}
