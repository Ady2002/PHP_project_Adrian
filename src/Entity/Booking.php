<?php

namespace App\Entity;

use App\Repository\BookingRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookingRepository::class)]
class Booking
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\OneToOne(targetEntity: Car::class, cascade: ['persist', 'remove'])]
    private $Car_ID;

    #[ORM\OneToOne(targetEntity: Stations::class, cascade: ['persist', 'remove'])]
    private $Station_ID;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $Charge_start;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $Charge_end;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCarID(): ?Car
    {
        return $this->Car_ID;
    }

    public function setCarID(?Car $Car_ID): self
    {
        $this->Car_ID = $Car_ID;

        return $this;
    }

    public function getStationID(): ?Stations
    {
        return $this->Station_ID;
    }

    public function setStationID(?Stations $Station_ID): self
    {
        $this->Station_ID = $Station_ID;

        return $this;
    }

    public function getChargeStart(): ?\DateTimeInterface
    {
        return $this->Charge_start;
    }

    public function setChargeStart(?\DateTimeInterface $Charge_start): self
    {
        $this->Charge_start = $Charge_start;

        return $this;
    }

    public function getChargeEnd(): ?\DateTimeInterface
    {
        return $this->Charge_end;
    }

    public function setChargeEnd(?\DateTimeInterface $Charge_end): self
    {
        $this->Charge_end = $Charge_end;

        return $this;
    }
}
