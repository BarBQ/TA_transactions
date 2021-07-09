<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Balance;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Balance|null find($id, $lockMode = null, $lockVersion = null)
 * @method Balance|null findOneBy(array $criteria, array $orderBy = null)
 * @method Balance[]    findAll()
 * @method Balance[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BalanceRepository extends ServiceEntityRepository
{
    /**
     * BalanceRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Balance::class);
    }

    /**
     * @param Balance $balance
     * @param int $amount
     * @return Balance
     * @throws \Exception
     */
    final public function withdrawall(Balance $balance, int $amount): Balance
    {
        if (!$this->isBalanceCoverWithdrawall($balance, $amount)) {
            throw new \Exception("Amount of Balance From is less then transaction amount");
        }

        $balance->setAmount($balance->getAmount() - $amount);

        return $balance;
    }

    /**
     * @param Balance $balance
     * @param int $amount
     * @return Balance
     */
    final public function enroll(Balance $balance, int $amount): Balance
    {
        $balance->setAmount($balance->getAmount() + $amount);

        return $balance;
    }

    /**
     * @param Balance $balance
     * @param int $amount
     * @return bool
     */
    final private function isBalanceCoverWithdrawall(Balance $balance, int $amount): bool
    {
        return $balance->getAmount() >= $amount;
    }
}
