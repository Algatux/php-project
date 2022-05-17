<?php declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Wallet;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class WalletFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $wallet = new Wallet();

        $wallet->setName('test wallet');
        $wallet->setDescription('test wallet description');

        /** @var User $user */
        $user = $this->getReference('user_'.UserFixtures::USER_AGALLI);
        $wallet->addUser($user);

        $manager->persist($wallet);
        $manager->flush();

        $this->addReference('wallet_test', $wallet);
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
        ];
    }
}
