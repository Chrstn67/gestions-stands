<?php

namespace App\Entity;

use App\Repository\SchedulesRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SchedulesRepository::class)]
class Schedules
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $timeslot = null;

    #[ORM\ManyToOne(inversedBy: 'has')]
    private ?Reservations $schedules = null;

    #[ORM\OneToOne(inversedBy: 'schedules', cascade: ['persist', 'remove'])]
    private ?Reservations $has = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTimeslot(): ?\DateTimeInterface
    {
        return $this->timeslot;
    }

    public function setTimeslot(\DateTimeInterface $timeslot): static
    {
        $this->timeslot = $timeslot;

        return $this;
    }

    public function getSchedules(): ?Reservations
    {
        return $this->schedules;
    }

    public function setSchedules(?Reservations $schedules): static
    {
        $this->schedules = $schedules;

        return $this;
    }

    public function getHas(): ?Reservations
    {
        return $this->has;
    }

    public function setHas(?Reservations $has): static
    {
        $this->has = $has;

        return $this;
    }
}
