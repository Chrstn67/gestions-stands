<?php

namespace App\Entity;

use App\Repository\StandRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StandRepository::class)]
class Stand
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $location = null;

    #[ORM\ManyToMany(targetEntity: Utilisateur::class, inversedBy: 'stands')]
    private Collection $run;

    #[ORM\ManyToMany(targetEntity: Utilisateur::class, mappedBy: 'run')]
    private Collection $utilisateurs;

    #[ORM\OneToOne(mappedBy: 'has', cascade: ['persist', 'remove'])]
    private ?Schedule $schedule = null;

    #[ORM\OneToMany(mappedBy: 'stand', targetEntity: Schedule::class)]
    private Collection $has;

    public function __construct()
    {
        $this->run = new ArrayCollection();
        $this->utilisateurs = new ArrayCollection();
        $this->has = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
     * @return Collection<int, Utilisateur>
     */
    public function getRun(): Collection
    {
        return $this->run;
    }

    public function addRun(Utilisateur $run): static
    {
        if (!$this->run->contains($run)) {
            $this->run->add($run);
        }

        return $this;
    }

    public function removeRun(Utilisateur $run): static
    {
        $this->run->removeElement($run);

        return $this;
    }

    /**
     * @return Collection<int, Utilisateur>
     */
    public function getUtilisateurs(): Collection
    {
        return $this->utilisateurs;
    }

    public function addUtilisateur(Utilisateur $utilisateur): static
    {
        if (!$this->utilisateurs->contains($utilisateur)) {
            $this->utilisateurs->add($utilisateur);
            $utilisateur->addRun($this);
        }

        return $this;
    }

    public function removeUtilisateur(Utilisateur $utilisateur): static
    {
        if ($this->utilisateurs->removeElement($utilisateur)) {
            $utilisateur->removeRun($this);
        }

        return $this;
    }

    public function getSchedule(): ?Schedule
    {
        return $this->schedule;
    }

    public function setSchedule(?Schedule $schedule): static
    {
        // unset the owning side of the relation if necessary
        if ($schedule === null && $this->schedule !== null) {
            $this->schedule->setHas(null);
        }

        // set the owning side of the relation if necessary
        if ($schedule !== null && $schedule->getHas() !== $this) {
            $schedule->setHas($this);
        }

        $this->schedule = $schedule;

        return $this;
    }

    /**
     * @return Collection<int, Schedule>
     */
    public function getHas(): Collection
    {
        return $this->has;
    }

    public function addHa(Schedule $ha): static
    {
        if (!$this->has->contains($ha)) {
            $this->has->add($ha);
            $ha->setStand($this);
        }

        return $this;
    }

    public function removeHa(Schedule $ha): static
    {
        if ($this->has->removeElement($ha)) {
            // set the owning side to null (unless already changed)
            if ($ha->getStand() === $this) {
                $ha->setStand(null);
            }
        }

        return $this;
    }
}
