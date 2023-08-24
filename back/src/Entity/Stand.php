<?php

namespace App\Entity;

use App\Repository\StandRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StandRepository::class)]
class Stand
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $stand_name = null;

    #[ORM\Column(length: 50)]
    private ?string $location = null;

    #[ORM\OneToOne(mappedBy: 'Stand', cascade: ['persist', 'remove'])]
    private ?Reservation $reservation = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStandName(): ?string
    {
        return $this->stand_name;
    }

    public function setStandName(string $stand_name): static
    {
        $this->stand_name = $stand_name;

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

    public function getReservation(): ?Reservation
    {
        return $this->reservation;
    }

    public function setReservation(Reservation $reservation): static
    {
        // set the owning side of the relation if necessary
        if ($reservation->getStand() !== $this) {
            $reservation->setStand($this);
        }

        $this->reservation = $reservation;

        return $this;
    }
}
