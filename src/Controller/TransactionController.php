<?php

declare(strict_types=1);

namespace App\Controller;

use App\DTO\CreateTransactionDTO;
use App\Entity\Balance;
use App\Entity\Transaction;
use App\Repository\TransactionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class TransactionController
 * @package App\Controller
 */
class TransactionController extends AbstractController
{
    /**
     * @Route("/transaction", name="transactions_list", methods={"GET"})
     */
    final public function index(TransactionRepository $repository): JsonResponse
    {
        $transactionsList = $repository->findAllSorted();

        return $this->json($transactionsList);
    }

    /**
     * @Route("/transaction/{id}", name="transaction_view", methods={"GET"})
     */
    final public function view(TransactionRepository $repository, int $id)
    {
        $transaction = $repository->find($id);

        return $this->json($transaction);
    }

    /**
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return JsonResponse
     * @throws \Exception
     * @Route("/transaction", name="transaction_create", methods={"POST"})
     *
     */
    final public function create(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $transactionRepository = $entityManager->getRepository(Transaction::class);
        $balanceRepository = $entityManager->getRepository(Balance::class);

        $dto = new CreateTransactionDTO($request, $entityManager);
        if (!$dto->isValid()) {
            return $this->json([
                'status' => 400,
                'errors' => $dto->getViolations()
            ]);
        }

        $entityManager->getConnection()->beginTransaction();

        try {
            $balanceFrom = $balanceRepository->withdrawal($dto->getBalanceFrom(), $dto->getAmount());
            $balanceTo = $balanceRepository->enroll($dto->getBalanceTo(), $dto->getAmount());
            $transaction = $transactionRepository->createNewTransaction($dto);

            $entityManager->persist($balanceFrom);
            $entityManager->persist($balanceTo);
            $entityManager->persist($transaction);
            $entityManager->flush();
            $entityManager->getConnection()->commit();

            $data = [
                'status' => 200,
                'message' => "Transaction created",
                'transactionId' => $transaction->getId()
            ];
        } catch (\Throwable $exception) {
            $entityManager->getConnection()->rollBack();

            $data = [
                'status' => 400,
                'error' => $exception->getMessage(),
            ];
        }

        return $this->json($data);
    }
}
