<?php

namespace App\Entity;

use App\Repository\StandRepository;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StandRepository::class)]

class Stand
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups("stand:read")]
    #[Groups("reservation:read")]
    private ?int $id = null;

    #[Groups("stand:read")]
    #[ORM\Column(length: 50)]
    private ?string $stand_name = null;

    #[Groups("stand:read")]
    #[ORM\Column(length: 50)]
    private ?string $location = null;

    #[Groups("stand:read")]

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
