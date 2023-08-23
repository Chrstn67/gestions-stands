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

    #[ORM\Column]
    private ?int $statut_resa = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $partner = null;

    #[ORM\ManyToMany(targetEntity: Schedule::class, inversedBy: 'reservations')]
    private Collection $planned;

    #[ORM\ManyToMany(targetEntity: Schedule::class, mappedBy: 'planned')]
    private Collection $schedules;

    #[ORM\OneToOne(inversedBy: 'reservation', cascade: ['persist', 'remove'])]
    private ?User $reserve = null;

    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'reserve')]
    private Collection $users;

    public function __construct()
    {
        $this->planned = new ArrayCollection();
        $this->schedules = new ArrayCollection();
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatutResa(): ?int
    {
        return $this->statut_resa;
    }

    public function setStatutResa(int $statut_resa): static
    {
        $this->statut_resa = $statut_resa;

        return $this;
    }

    public function getPartner(): ?string
    {
        return $this->partner;
    }

    public function setPartner(?string $partner): static
    {
        $this->partner = $partner;

        return $this;
    }

    /**
     * @return Collection<int, Schedule>
     */
    public function getPlanned(): Collection
    {
        return $this->planned;
    }

    public function addPlanned(Schedule $planned): static
    {
        if (!$this->planned->contains($planned)) {
            $this->planned->add($planned);
        }

        return $this;
    }

    public function removePlanned(Schedule $planned): static
    {
        $this->planned->removeElement($planned);

        return $this;
    }

    /**
     * @return Collection<int, Schedule>
     */
    public function getSchedules(): Collection
    {
        return $this->schedules;
    }

    public function addSchedule(Schedule $schedule): static
    {
        if (!$this->schedules->contains($schedule)) {
            $this->schedules->add($schedule);
            $schedule->addPlanned($this);
        }

        return $this;
    }

    public function removeSchedule(Schedule $schedule): static
    {
        if ($this->schedules->removeElement($schedule)) {
            $schedule->removePlanned($this);
        }

        return $this;
    }

    public function getReserve(): ?User
    {
        return $this->reserve;
    }

    public function setReserve(?User $reserve): static
    {
        $this->reserve = $reserve;

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
            $user->addReserve($this);
        }

        return $this;
    }

    public function removeUser(User $user): static
    {
        if ($this->users->removeElement($user)) {
            $user->removeReserve($this);
        }

        return $this;
    }
}
