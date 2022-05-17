<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Wallet;
use App\Model\Request\TransactionCreate;
use App\Repository\TransactionRepository;
use App\Service\RequestMapper;
use App\Service\RequestModelValidator;
use App\Service\TransactionPersister;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: 'api')]
class TransactionController extends AbstractController
{
    public function __construct(
        private readonly RequestMapper $requestMapper,
        private readonly RequestModelValidator $modelValidator
    )
    {
    }

    #[Route('/transaction', name: 'app_transaction')]
    public function index(TransactionRepository $repository): JsonResponse
    {
        return new JsonResponse($repository->findAll());
    }

    #[Route('/transaction/create', name: 'app_transaction_create', methods: 'POST')]
    public function create(
        Request $request,
        EntityManagerInterface $entityManager,
        TransactionPersister $transactionPersister
    ): Response
    {
        $userRepo = $entityManager->getRepository(User::class);
        $walletRepo = $entityManager->getRepository(Wallet::class);

        $entityManager->beginTransaction();
        try {
            $requestModel = new TransactionCreate();
            $this->requestMapper->mapJsonRequest($request, $requestModel);
            $this->modelValidator->validate($requestModel);

            $user = $userRepo->findOneBy(['id' => $requestModel->user]);
            $wallet = $walletRepo->findOneBy(['id' => $requestModel->wallet]);

            $transaction = $transactionPersister->create($requestModel->amount, $requestModel->motivation, $user, $wallet);

            $entityManager->commit();
        } catch (\Exception $e) {
            $entityManager->rollback();
            $entityManager->close();
            return new JsonResponse(['error' => $e->getMessage()], 500);
        }

        return new JsonResponse(['id' => $transaction->getId()], 201);
    }
}
