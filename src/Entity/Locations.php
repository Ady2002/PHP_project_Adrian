<?php

namespace App\Entity;

use App\Repository\LocationsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LocationsRepository::class)]
class Locations
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $Name;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $Total_spots;

    #[ORM\Column(type: 'float', nullable: true)]
    private $Lat;

    #[ORM\Column(type: 'float', nullable: true)]
    private $Longitude;

    #[ORM\Column(type: 'float', nullable: true)]
    private $Price;

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

    public function getTotalSpots(): ?int
    {
        return $this->Total_spots;
    }

    public function setTotalSpots(?int $Total_spots): self
    {
        $this->Total_spots = $Total_spots;

        return $this;
    }

    public function getLat(): ?float
    {
        return $this->Lat;
    }

    public function setLat(?float $Lat): self
    {
        $this->Lat = $Lat;

        return $this;
    }

    public function getLongitude(): ?float
    {
        return $this->Longitude;
    }

    public function setLongitude(?float $Longitude): self
    {
        $this->Longitude = $Longitude;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->Price;
    }

    public function setPrice(?float $Price): self
    {
        $this->Price = $Price;

        return $this;
    }
}
