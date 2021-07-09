<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Transaction;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\DTO\CreateTransactionDTO;

/**
 * @method Transaction|null find($id, $lockMode = null, $lockVersion = null)
 * @method Transaction|null findOneBy(array $criteria, array $orderBy = null)
 * @method Transaction[]    findAll()
 * @method Transaction[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TransactionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Transaction::class);
    }

    /**
     * @param string $sort
     * @return Transaction[] Returns an array of Transaction objects
     */
    final public function findAllSorted(string $sort = 'DESC'): array
    {
        return $this->createQueryBuilder('t')
            ->orderBy('t.id', $sort)
            ->getQuery()
            ->getResult();
    }

    /**
     * @param CreateTransactionDTO $dto
     * @return Transaction
     */
    final public function createNewTransaction(CreateTransactionDTO $dto): Transaction
    {
        $transaction = new Transaction();
        $transaction->setBalanceFrom($dto->getBalanceFrom());
        $transaction->setBalanceTo($dto->getBalanceTo());
        $transaction->setAmount($dto->getAmount());
        $transaction->setCurrency('RUB');

        return $transaction;
    }
}
