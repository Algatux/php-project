<?php declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Transaction;
use App\Entity\User;
use App\Entity\Wallet;
use App\Enum\TransferType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class TransactionFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        /** @var User $user */
        $user = $this->getReference("user_".UserFixtures::USER_AGALLI);

        $transaction = new Transaction();
        $transaction->setAmount(100.00);
        $transaction->setMotivation('test');
        $transaction->setType(TransferType::IN);
        $transaction->setUser($user);

        /** @var Wallet $wallet */
        $wallet = $this->getReference('wallet_test');

        $transaction->setWallet($wallet);

        $manager->persist($transaction);
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
            WalletFixtures::class
        ];
    }
}
