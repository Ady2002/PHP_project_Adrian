<?php

namespace App\Entity;

use App\Repository\StationsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StationsRepository::class)]
class Stations
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Locations::class, cascade: ['persist', 'remove'])]
    private $Location_ID;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $Station_Type;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $Power;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLocationID(): ?Locations
    {
        return $this->Location_ID;
    }

    public function setLocationID(?Locations $Location_ID): self
    {
        $this->Location_ID = $Location_ID;

        return $this;
    }

    public function getStationType(): ?string
    {
        return $this->Station_Type;
    }

    public function setStationType(?string $Station_Type): self
    {
        $this->Station_Type = $Station_Type;

        return $this;
    }

    public function getPower(): ?int
    {
        return $this->Power;
    }

    public function setPower(?int $Power): self
    {
        $this->Power = $Power;

        return $this;
    }
}
