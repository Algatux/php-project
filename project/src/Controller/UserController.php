<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

#[Route(path: 'api')]
class UserController extends AbstractController
{
    #[Route('/user', name: 'user')]
    public function index(#[CurrentUser] ?User $user): JsonResponse
    {
        return new JsonResponse($user);
    }

    #[Route('/user/create', name: 'user_create')]
    public function create(UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $user->setEmail('a.galli85@gmail.com');
        $user->setRoles(['ROLE_ADMIN']);
        $user->setPassword(
            $userPasswordHasher->hashPassword($user, 'letmein')
        );

        $entityManager->persist($user);
        $entityManager->flush();

        return new JsonResponse($user, 201);
    }
}
