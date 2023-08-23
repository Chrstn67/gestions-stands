<?php

namespace App\Entity;

use App\Repository\ScheduleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ScheduleRepository::class)]
class Schedule
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $calentar_date = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $start_time = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $end_time = null;

    #[ORM\Column]
    private ?int $statut_schedule = null;

    #[ORM\OneToOne(inversedBy: 'schedule', cascade: ['persist', 'remove'])]
    private ?Stand $has = null;

    #[ORM\ManyToOne(inversedBy: 'has')]
    private ?Stand $stand = null;

    #[ORM\ManyToMany(targetEntity: Reservation::class, mappedBy: 'planned')]
    private Collection $reservations;

    #[ORM\ManyToMany(targetEntity: Reservation::class, inversedBy: 'schedules')]
    private Collection $planned;

    public function __construct()
    {
        $this->reservations = new ArrayCollection();
        $this->planned = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCalentarDate(): ?\DateTimeInterface
    {
        return $this->calentar_date;
    }

    public function setCalentarDate(\DateTimeInterface $calentar_date): static
    {
        $this->calentar_date = $calentar_date;

        return $this;
    }

    public function getStartTime(): ?\DateTimeInterface
    {
        return $this->start_time;
    }

    public function setStartTime(\DateTimeInterface $start_time): static
    {
        $this->start_time = $start_time;

        return $this;
    }

    public function getEndTime(): ?\DateTimeInterface
    {
        return $this->end_time;
    }

    public function setEndTime(\DateTimeInterface $end_time): static
    {
        $this->end_time = $end_time;

        return $this;
    }

    public function getStatutSchedule(): ?int
    {
        return $this->statut_schedule;
    }

    public function setStatutSchedule(int $statut_schedule): static
    {
        $this->statut_schedule = $statut_schedule;

        return $this;
    }

    public function getHas(): ?Stand
    {
        return $this->has;
    }

    public function setHas(?Stand $has): static
    {
        $this->has = $has;

        return $this;
    }

    public function getStand(): ?Stand
    {
        return $this->stand;
    }

    public function setStand(?Stand $stand): static
    {
        $this->stand = $stand;

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
            $reservation->addPlanned($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): static
    {
        if ($this->reservations->removeElement($reservation)) {
            $reservation->removePlanned($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Reservation>
     */
    public function getPlanned(): Collection
    {
        return $this->planned;
    }

    public function addPlanned(Reservation $planned): static
    {
        if (!$this->planned->contains($planned)) {
            $this->planned->add($planned);
        }

        return $this;
    }

    public function removePlanned(Reservation $planned): static
    {
        $this->planned->removeElement($planned);

        return $this;
    }
}
