<?php

namespace App\Entity;

use App\Repository\ReservationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReservationRepository::class)]
class Reservation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups("reservation:read")]

    private ?int $id = null;


    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Groups("reservation:read")]

    private ?\DateTimeInterface $calendar_date = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    #[Groups("reservation:read")]

    private ?\DateTimeInterface $hour_time = null;

    #[ORM\Column]
    #[Groups("reservation:read")]

    private ?int $statut_resa = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups("reservation:read")]

    private ?\DateTimeInterface $created_at = null;


    

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'reservations')]
    private Collection $user;

    #[ORM\ManyToOne(inversedBy: 'stand')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Stand $stand = null;

    public function __construct()
    {
        $this->user = new ArrayCollection();
    }

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

   
    
    public function getFormattedStatut(): string
    {
        $statutLabels = [
            0 => 'En attente',
            1 => 'Acceptée',
            2 => 'Refusée',
        ];

        return $statutLabels[$this->statut_resa];
    }

    /**
     * @return Collection<int, User>
     */
    public function getUser(): Collection
    {
        return $this->user;
    }

    public function addUser(User $user): static
    {
        if (!$this->user->contains($user)) {
            $this->user->add($user);
        }

        return $this;
    }

    public function removeUser(User $user): static
    {
        $this->user->removeElement($user);

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
}
