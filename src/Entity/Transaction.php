<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\TransactionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TransactionRepository::class)
 */
class Transaction
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=Balance::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $balance_from;

    /**
     * @ORM\OneToOne(targetEntity=Balance::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $balance_to;

    /**
     * @ORM\Column(type="float")
     */
    private $amount;

    /**
     * @ORM\Column(type="string", length=3)
     */
    private $currency;

    /**
     * @ORM\Column(type="integer")
     */
    private $created_at;
    
    /**
     * @return int|null
     */
    public final function getId(): ?int
    {
        return $this->id;
    }
    
    /**
     * @return Balance|null
     */
    public final function getBalanceFrom(): ?Balance
    {
        return $this->balance_from;
    }
    
    /**
     * @param Balance $balance_from
     *
     * @return $this
     */
    public final function setBalanceFrom(Balance $balance_from): self
    {
        $this->balance_from = $balance_from;

        return $this;
    }
    
    /**
     * @return Balance|null
     */
    public final function getBalanceTo(): ?Balance
    {
        return $this->balance_to;
    }
    
    /**
     * @param Balance $balance_to
     *
     * @return $this
     */
    public final function setBalanceTo(Balance $balance_to): self
    {
        $this->balance_to = $balance_to;

        return $this;
    }
    
    /**
     * @return float|null
     */
    public final function getAmount(): ?float
    {
        return $this->amount;
    }
    
    /**
     * @param float $amount
     *
     * @return $this
     */
    public final function setAmount(float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }
    
    /**
     * @return string|null
     */
    public final function getCurrency(): ?string
    {
        return $this->currency;
    }
    
    /**
     * @param string $currency
     *
     * @return $this
     */
    public final function setCurrency(string $currency): self
    {
        $this->currency = $currency;

        return $this;
    }
    
    /**
     * @return int|null
     */
    public final function getCreatedAt(): ?int
    {
        return $this->created_at;
    }
    
    /**
     * @param int $created_at
     *
     * @return $this
     */
    public final function setCreatedAt(int $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }
}
