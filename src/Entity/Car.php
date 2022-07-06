<?php

namespace App\Entity;

use App\Repository\CarRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CarRepository::class)]
class Car
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $License_plate;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $Charge_Type;

    #[ORM\ManyToOne(targetEntity: User::class)]
    private $User_ID;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLicensePlate(): ?string
    {
        return $this->License_plate;
    }

    public function setLicensePlate(?string $License_plate): self
    {
        $this->License_plate = $License_plate;

        return $this;
    }

    public function getChargeType(): ?string
    {
        return $this->Charge_Type;
    }

    public function setChargeType(?string $Charge_Type): self
    {
        $this->Charge_Type = $Charge_Type;

        return $this;
    }

    public function getUserID(): ?User
    {
        return $this->User_ID;
    }

    public function setUserID(?User $User_ID): self
    {
        $this->User_ID = $User_ID;

        return $this;
    }
}
