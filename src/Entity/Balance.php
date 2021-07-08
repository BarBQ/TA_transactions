<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\BalanceRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BalanceRepository::class)
 */
class Balance
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=User::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="float")
     */
    private $amount;

    /**
     * @ORM\Column(type="string", length=3)
     */
    private $currency;
    
    /**
     * @return int|null
     */
    public final function getId(): ?int
    {
        return $this->id;
    }
    
    /**
     * @return User|null
     */
    public final function getUser(): ?User
    {
        return $this->user;
    }
    
    /**
     * @param User $user
     *
     * @return $this
     */
    public final function setUser(User $user): self
    {
        $this->user = $user;

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
}
