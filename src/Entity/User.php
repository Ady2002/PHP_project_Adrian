<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $Name;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $Email;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $City;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(?string $Name): self
    {
        $this->Name = $Name;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->Email;
    }

    public function setEmail(?string $Email): self
    {
        $this->Email = $Email;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->City;
    }

    public function setCity(?string $City): self
    {
        $this->City = $City;

        return $this;
    }
}
