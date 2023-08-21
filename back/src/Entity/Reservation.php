<?php

namespace App\Entity;

use App\Repository\ReservationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReservationRepository::class)]
class Reservation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToMany(mappedBy: 'reservation', targetEntity: User::class)]
    private Collection $choose;

    public function __construct()
    {
        $this->choose = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, User>
     */
    public function getChoose(): Collection
    {
        return $this->choose;
    }

    public function addChoose(User $choose): static
    {
        if (!$this->choose->contains($choose)) {
            $this->choose->add($choose);
            $choose->setReservation($this);
        }

        return $this;
    }

    public function removeChoose(User $choose): static
    {
        if ($this->choose->removeElement($choose)) {
            // set the owning side to null (unless already changed)
            if ($choose->getReservation() === $this) {
                $choose->setReservation(null);
            }
        }

        return $this;
    }
}
