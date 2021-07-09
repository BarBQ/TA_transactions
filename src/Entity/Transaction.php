<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\TransactionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TransactionRepository::class)
 * @ORM\Table(name="transaction")
 * @ORM\HasLifecycleCallbacks
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
     * @ORM\Column(type="integer")
     */
    private $balance_from_id;

    /**
     * @ORM\OneToOne(targetEntity=Balance::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     * @ORM\Column(type="integer")
     */
    private $balance_to_id;

    /**
     * @ORM\Column(type="integer")
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
     * Gets triggered only on insert

     * @ORM\PrePersist
     */
    public function onPrePersist()
    {
        $this->created_at = (new \DateTime("now"))->getTimestamp();
    }
    
    /**
     * @return int
     */
    final public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    final public function getBalanceFrom(): int
    {
        return $this->balance_from_id;
    }

    /**
     * @param Balance $balance
     * @return $this
     */
    final public function setBalanceFrom(Balance $balance): self
    {
        $this->balance_from_id = $balance->getId();

        return $this;
    }

    /**
     * @return int
     */
    final public function getBalanceTo(): int
    {
        return $this->balance_to_id;
    }

    /**
     * @param Balance $balance
     * @return $this
     */
    final public function setBalanceTo(Balance $balance): self
    {
        $this->balance_to_id = $balance->getId();

        return $this;
    }
    
    /**
     * @return int
     */
    final public function getAmount(): int
    {
        return $this->amount;
    }

    /**
     * @param int $amount
     * @return $this
     */
    final public function setAmount(int $amount): self
    {
        $this->amount = $amount;

        return $this;
    }
    
    /**
     * @return string
     */
    final public function getCurrency(): string
    {
        return $this->currency;
    }
    
    /**
     * @param string $currency
     *
     * @return $this
     */
    final public function setCurrency(string $currency): self
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * @return string
     * @throws \Exception
     */
    final public function getCreatedAt(): string
    {
        return \DateTime::createFromFormat('U', (string)$this->created_at)->format(DATE_ATOM);
    }
    
    /**
     * @param int $created_at
     *
     * @return $this
     */
    final public function setCreatedAt(int $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }
}
