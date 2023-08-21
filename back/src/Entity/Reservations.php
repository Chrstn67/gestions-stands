<?php

namespace App\Entity;

use App\Repository\ReservationsRepository;
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
}
