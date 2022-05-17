<?php declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public const USER_AGALLI = 'a.galli85@gmail.com';

    public function __construct(private readonly UserPasswordHasherInterface $userPasswordHasher) {}

    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setEmail(self::USER_AGALLI);
        $user->setRoles(['ROLE_ADMIN']);
        $user->setPassword(
            $this->userPasswordHasher->hashPassword($user, 'letmein')
        );

        $manager->persist($user);
        $manager->flush();

        $this->addReference("user_{$user->getEmail()}", $user);
    }
}
