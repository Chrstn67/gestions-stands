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
}
