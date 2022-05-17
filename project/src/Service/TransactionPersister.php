<?php declare(strict_types=1);

namespace App\Service;

use App\Entity\Transaction;
use App\Entity\User;
use App\Entity\Wallet;
use App\Enum\TransferType;
use Doctrine\ORM\EntityManagerInterface;

class TransactionPersister
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    public function create(
        float        $amount,
        string       $motivation,
        User         $user,
        Wallet       $wallet,
        TransferType $type = TransferType::OUT
    ): Transaction
    {
        $transaction = new Transaction();
        $transaction->setAmount($amount);
        $transaction->setMotivation($motivation);
        $transaction->setType($type);
        $transaction->setUser($user);
        $transaction->setWallet($wallet);

        $this->entityManager->persist($transaction);
        $this->entityManager->flush();

        return $transaction;
    }
}
