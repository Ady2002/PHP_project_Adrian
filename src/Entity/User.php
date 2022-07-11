<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;


#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['Email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
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

	#[ORM\Column(type: 'string', length: 255)]
   	private $password;

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

	public function getPassword(): ?string
   	{
   		return $this->password;
   	}

	public function setPassword(string $password): self
   	{
   		$this->password = $password;
   
   		return $this;
   	}

	public function getRoles(): array
   	{
   		return ['user'];
   	}

	public function eraseCredentials()
   	{
   
   	}

	public function getUserIdentifier(): string
   	{
   		return $this->getEmail();
   	}
}
