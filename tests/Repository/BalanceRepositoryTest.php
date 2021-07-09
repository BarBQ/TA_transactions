<?php

declare(strict_types=1);

namespace App\Tests\Repository;

use App\Entity\Balance;
use App\Repository\BalanceRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Class BalanceRepositoryTest
 * @package App\Tests\Repository
 */
class BalanceRepositoryTest extends KernelTestCase
{
    /**
     * @var BalanceRepository
     */
    private BalanceRepository $balanceRepository;

    protected function setUp(): void
    {
        $entityManager = self::bootKernel()->getContainer()
            ->get('doctrine')
            ->getManager();

        $this->balanceRepository = $entityManager->getRepository(Balance::class);
    }

    /**
     * Проверка попытки списания суммы, не превышающей остаток на балансе
     * Тест считается успешным, если сумма до операции отличается от суммы после
     * @throws \Exception
     */
    public function testWithdrawal(): void
    {
        $balance = $this->balanceRepository->find(1);
        $initialBalanceAmount = $balance->getAmount();

        $this->balanceRepository->withdrawal($balance, $balance->getAmount());

        $this->assertNotEquals($balance->getAmount(), $initialBalanceAmount);
    }

    /**
     * Проверка попытки зачисления суммы на баланс
     * Тест считается успешным, если сумма до операции отличается от суммы после
     * @throws \Exception
     */
    public function testEnroll(): void
    {
        $balance = $this->balanceRepository->find(1);
        $initialBalanceAmount = $balance->getAmount();

        $this->balanceRepository->enroll($balance, $balance->getAmount());

        $this->assertNotEquals($balance->getAmount(), $initialBalanceAmount);
    }

    /**
     * Проверка попытки списания суммы, превышающей остаток на балансе
     * @throws \Exception
     */
    public function testWithdrawalMoreThanBalanceAmount(): void
    {
        $balance = $this->balanceRepository->find(1);

        try {
            $this->balanceRepository->withdrawal($balance, $balance->getAmount() + 100);
        } catch (\Throwable $exception) {
            $this->assertEquals($exception->getMessage(), "Amount of Balance From is less then transaction amount");
        }
    }
}
