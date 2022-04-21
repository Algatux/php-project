<?php

namespace App\Controller;

use App\Entity\Transaction;
use App\Entity\User;
use App\Enum\TransferType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TransactionController extends AbstractController
{
    #[Route('/transaction', name: 'app_transaction')]
    public function index(): Response
    {
        return $this->render('transaction/index.html.twig', [
            'controller_name' => 'TransactionController',
        ]);
    }

    #[Route('/transaction/create', name: 'app_transaction_create')]
    public function create(EntityManagerInterface $entityManager): Response
    {
        $repo = $entityManager->getRepository(User::class);

        $user = $repo->findOneBy(['email' => 'a.galli85@gmail.com']);

        $transaction = new Transaction();
        $transaction->setAmount(100.00);
        $transaction->setMotivation('test');
        $transaction->setType(TransferType::IN);
        $transaction->setUser($user);

        $entityManager->persist($transaction);
        $entityManager->flush();

        return new JsonResponse([]);
    }
}
