<?php

namespace App\Entity;

use App\Repository\StandsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StandsRepository::class)]
class Stands
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $name_stand = null;

    #[ORM\Column(length: 50)]
    private ?string $location = null;

    #[ORM\ManyToOne(inversedBy: 'run')]
    private ?Reservations $reservations = null;

    #[ORM\OneToOne(inversedBy: 'stands', cascade: ['persist', 'remove'])]
    private ?Reservations $run = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameStand(): ?string
    {
        return $this->name_stand;
    }

    public function setNameStand(string $name_stand): static
    {
        $this->name_stand = $name_stand;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(string $location): static
    {
        $this->location = $location;

        return $this;
    }

    public function getReservations(): ?Reservations
    {
        return $this->reservations;
    }

    public function setReservations(?Reservations $reservations): static
    {
        $this->reservations = $reservations;

        return $this;
    }

    public function getRun(): ?Reservations
    {
        return $this->run;
    }

    public function setRun(?Reservations $run): static
    {
        $this->run = $run;

        return $this;
    }
}
