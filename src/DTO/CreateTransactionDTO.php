<?php

declare(strict_types=1);

namespace App\DTO;

use App\Entity\Balance;
use App\Repository\BalanceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class CreateTransactionDTO
 * @package DTO
 */
class CreateTransactionDTO
{
    /**
     * @var int|mixed|null
     */
    private ?int $balanceFromId = null;

    /**
     * @var int|null
     */
    private ?int $balanceToId = null;

    /**
     * @var int|null
     */
    private ?int $amount = null;

    /**
     * @var array
     */
    private array $errors = [];

    /**
     * @var BalanceRepository
     */
    private BalanceRepository $balanceRepository;

    /**
     * CreateTransactionDTO constructor.
     * @param Request $request
     */
    public function __construct(Request $request, EntityManagerInterface $entityManager)
    {
        $this->balanceFromId = (int)$request->get('balance_from');
        $this->balanceToId = (int)$request->get('balance_to');
        $this->amount = (int)$request->get('amount');
        $this->balanceRepository = $entityManager->getRepository(Balance::class);
    }

    /**
     * @return int|null
     */
    final public function getAmount(): ?int
    {
        return $this->amount;
    }

    /**
     * @return Balance|null
     */
    final public function getBalanceTo(): ?Balance
    {
        if (!empty($this->balanceToId)) {
            return $this->balanceRepository->find($this->balanceToId);
        }

        return null;
    }

    /**
     * @return Balance|null
     */
    final public function getBalanceFrom(): ?Balance
    {
        if (!empty($this->balanceFromId)) {
            return $this->balanceRepository->find($this->balanceFromId);
        }

        return null;
    }

    /**
     * @return array
     */
    final public function getViolations(): array
    {
        return $this->errors;
    }

    /**
     * @return bool
     */
    final public function isValid(): bool
    {
        $this->errors = [];

        if (is_null($this->getBalanceFrom())) {
            $this->errors['balance_from'] = "Correct Balance ID must be provided";
        }

        if (is_null($this->getBalanceTo())) {
            $this->errors['balance_to'] = "Correct Balance ID must be provided";
        }

        if ($this->getBalanceFrom() === $this->getBalanceTo()) {
            $this->errors['balance_to'] = "Balance must be different from the other";
        }

        if (empty($this->amount)) {
            $this->errors['amount'] = "Value must be occurred";
        }

        return empty($this->errors);
    }
}