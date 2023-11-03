<?php

namespace App\Entity;

use App\Repository\StandRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StandRepository::class)]

class Stand
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups("stand:read")]

    private ?int $id = null;

    #[Groups("stand:read")]
    #[ORM\Column(length: 50)]
    private ?string $stand_name = null;

    #[Groups("stand:read")]
    #[ORM\Column(length: 50)]
    private ?string $location = null;

    #[ORM\OneToMany(mappedBy: 'stand', targetEntity: Reservation::class, orphanRemoval: true)]
    private Collection $reservations;

   

    public function __construct()
    {
        $this->reservations = new ArrayCollection();
       
    }

   
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

    /**
     * @return Collection<int, Reservation>
     */
    public function getReservations(): Collection
    {
        return $this->reservations;
    }

    public function addReservation(Reservation $reservation): static
    {
        if (!$this->reservations->contains($reservation)) {
            $this->reservations->add($reservation);
            $reservation->setStand($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): static
    {
        if ($this->reservations->removeElement($reservation)) {
            // set the owning side to null (unless already changed)
            if ($reservation->getStand() === $this) {
                $reservation->setStand(null);
            }
        }

        return $this;
    }

   
   
}
