<?php

namespace App\Entity;

use App\Repository\ReservationsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReservationsRepository::class)]
class Reservations
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?int $statut_resa = null;

    #[ORM\OneToMany(mappedBy: 'reservations', targetEntity: Stands::class)]
    private Collection $run;

    #[ORM\OneToMany(mappedBy: 'schedules', targetEntity: Schedules::class)]
    private Collection $has;

    #[ORM\OneToOne(mappedBy: 'run', cascade: ['persist', 'remove'])]
    private ?Stands $stands = null;

    #[ORM\OneToOne(mappedBy: 'has', cascade: ['persist', 'remove'])]
    private ?Schedules $schedules = null;

    #[ORM\OneToOne(inversedBy: 'reservations', cascade: ['persist', 'remove'])]
    private ?User $chosse = null;

    public function __construct()
    {
        $this->run = new ArrayCollection();
        $this->has = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatutResa(): ?int
    {
        return $this->statut_resa;
    }

    public function setStatutResa(?int $statut_resa): static
    {
        $this->statut_resa = $statut_resa;

        return $this;
    }

    /**
     * @return Collection<int, Stands>
     */
    public function getRun(): Collection
    {
        return $this->run;
    }

    public function addRun(Stands $run): static
    {
        if (!$this->run->contains($run)) {
            $this->run->add($run);
            $run->setReservations($this);
        }

        return $this;
    }

    public function removeRun(Stands $run): static
    {
        if ($this->run->removeElement($run)) {
            // set the owning side to null (unless already changed)
            if ($run->getReservations() === $this) {
                $run->setReservations(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Schedules>
     */
    public function getHas(): Collection
    {
        return $this->has;
    }

    public function addHa(Schedules $ha): static
    {
        if (!$this->has->contains($ha)) {
            $this->has->add($ha);
            $ha->setSchedules($this);
        }

        return $this;
    }

    public function removeHa(Schedules $ha): static
    {
        if ($this->has->removeElement($ha)) {
            // set the owning side to null (unless already changed)
            if ($ha->getSchedules() === $this) {
                $ha->setSchedules(null);
            }
        }

        return $this;
    }

    public function getStands(): ?Stands
    {
        return $this->stands;
    }

    public function setStands(?Stands $stands): static
    {
        // unset the owning side of the relation if necessary
        if ($stands === null && $this->stands !== null) {
            $this->stands->setRun(null);
        }

        // set the owning side of the relation if necessary
        if ($stands !== null && $stands->getRun() !== $this) {
            $stands->setRun($this);
        }

        $this->stands = $stands;

        return $this;
    }

    public function getSchedules(): ?Schedules
    {
        return $this->schedules;
    }

    public function setSchedules(?Schedules $schedules): static
    {
        // unset the owning side of the relation if necessary
        if ($schedules === null && $this->schedules !== null) {
            $this->schedules->setHas(null);
        }

        // set the owning side of the relation if necessary
        if ($schedules !== null && $schedules->getHas() !== $this) {
            $schedules->setHas($this);
        }

        $this->schedules = $schedules;

        return $this;
    }

    public function getChosse(): ?User
    {
        return $this->chosse;
    }

    public function setChosse(?User $chosse): static
    {
        $this->chosse = $chosse;

        return $this;
    }
}
