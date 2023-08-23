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

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'stands')]
    private Collection $run;

    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'run')]
    private Collection $users;

    #[ORM\OneToOne(mappedBy: 'has', cascade: ['persist', 'remove'])]
    private ?Schedule $schedule = null;

    #[ORM\OneToMany(mappedBy: 'stand', targetEntity: Schedule::class)]
    private Collection $has;

    public function __construct()
    {
        $this->run = new ArrayCollection();
        $this->users = new ArrayCollection();
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
     * @return Collection<int, User>
     */
    public function getRun(): Collection
    {
        return $this->run;
    }

    public function addRun(User $run): static
    {
        if (!$this->run->contains($run)) {
            $this->run->add($run);
        }

        return $this;
    }

    public function removeRun(User $run): static
    {
        $this->run->removeElement($run);

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): static
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->addRun($this);
        }

        return $this;
    }

    public function removeUser(User $user): static
    {
        if ($this->users->removeElement($user)) {
            $user->removeRun($this);
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
