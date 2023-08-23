<?php

namespace App\Entity;

use App\Repository\UtilisateurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UtilisateurRepository::class)]
class Utilisateur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $name = null;

    #[ORM\Column(length: 50)]
    private ?string $email = null;

    #[ORM\Column(length: 50)]
    private ?string $password = null;

    #[ORM\OneToMany(mappedBy: 'utilisateur', targetEntity: Role::class)]
    private Collection $asign;

    #[ORM\ManyToOne(inversedBy: 'asign')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Role $role = null;

    #[ORM\ManyToMany(targetEntity: Stand::class, mappedBy: 'run')]
    private Collection $stands;

    #[ORM\ManyToMany(targetEntity: Stand::class, inversedBy: 'utilisateurs')]
    private Collection $run;

    #[ORM\OneToOne(mappedBy: 'reserve', cascade: ['persist', 'remove'])]
    private ?Reservation $reservation = null;

    #[ORM\ManyToMany(targetEntity: Reservation::class, inversedBy: 'utilisateurs')]
    private Collection $reserve;

    public function __construct()
    {
        $this->asign = new ArrayCollection();
        $this->stands = new ArrayCollection();
        $this->run = new ArrayCollection();
        $this->reserve = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return Collection<int, Role>
     */
    public function getAsign(): Collection
    {
        return $this->asign;
    }

    public function addAsign(Role $asign): static
    {
        if (!$this->asign->contains($asign)) {
            $this->asign->add($asign);
            $asign->setUtilisateur($this);
        }

        return $this;
    }

    public function removeAsign(Role $asign): static
    {
        if ($this->asign->removeElement($asign)) {
            // set the owning side to null (unless already changed)
            if ($asign->getUtilisateur() === $this) {
                $asign->setUtilisateur(null);
            }
        }

        return $this;
    }

    public function getRole(): ?Role
    {
        return $this->role;
    }

    public function setRole(?Role $role): static
    {
        $this->role = $role;

        return $this;
    }

    /**
     * @return Collection<int, Stand>
     */
    public function getStands(): Collection
    {
        return $this->stands;
    }

    public function addStand(Stand $stand): static
    {
        if (!$this->stands->contains($stand)) {
            $this->stands->add($stand);
            $stand->addRun($this);
        }

        return $this;
    }

    public function removeStand(Stand $stand): static
    {
        if ($this->stands->removeElement($stand)) {
            $stand->removeRun($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Stand>
     */
    public function getRun(): Collection
    {
        return $this->run;
    }

    public function addRun(Stand $run): static
    {
        if (!$this->run->contains($run)) {
            $this->run->add($run);
        }

        return $this;
    }

    public function removeRun(Stand $run): static
    {
        $this->run->removeElement($run);

        return $this;
    }

    public function getReservation(): ?Reservation
    {
        return $this->reservation;
    }

    public function setReservation(?Reservation $reservation): static
    {
        // unset the owning side of the relation if necessary
        if ($reservation === null && $this->reservation !== null) {
            $this->reservation->setReserve(null);
        }

        // set the owning side of the relation if necessary
        if ($reservation !== null && $reservation->getReserve() !== $this) {
            $reservation->setReserve($this);
        }

        $this->reservation = $reservation;

        return $this;
    }

    /**
     * @return Collection<int, Reservation>
     */
    public function getReserve(): Collection
    {
        return $this->reserve;
    }

    public function addReserve(Reservation $reserve): static
    {
        if (!$this->reserve->contains($reserve)) {
            $this->reserve->add($reserve);
        }

        return $this;
    }

    public function removeReserve(Reservation $reserve): static
    {
        $this->reserve->removeElement($reserve);

        return $this;
    }
}
