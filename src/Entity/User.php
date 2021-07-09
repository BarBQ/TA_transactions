<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;
    
    /**
     * @return int|null
     */
    final public function getId(): ?int
    {
        return $this->id;
    }
    
    /**
     * @return string|null
     */
    final public function getName(): ?string
    {
        return $this->name;
    }
    
    /**
     * @param string $name
     *
     * @return $this
     */
    final public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
}
