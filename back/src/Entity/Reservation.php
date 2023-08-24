<?php

namespace App\Entity;

use App\Repository\ReservationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReservationRepository::class)]
class Reservation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $calendar_date = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $hour_time = null;

    #[ORM\Column]
    private ?int $statut_resa = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $created_at = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCalendarDate(): ?\DateTimeInterface
    {
        return $this->calendar_date;
    }

    public function setCalendarDate(\DateTimeInterface $calendar_date): static
    {
        $this->calendar_date = $calendar_date;

        return $this;
    }

    public function getHourTime(): ?\DateTimeInterface
    {
        return $this->hour_time;
    }

    public function setHourTime(\DateTimeInterface $hour_time): static
    {
        $this->hour_time = $hour_time;

        return $this;
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

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }
}
