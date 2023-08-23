<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 50)]
    private ?string $name = null;

    #[ORM\ManyToMany(targetEntity: Stand::class, mappedBy: 'run')]
    private Collection $stands;

    #[ORM\ManyToMany(targetEntity: Stand::class, inversedBy: 'users')]
    private Collection $run;

    #[ORM\OneToOne(mappedBy: 'reserve', cascade: ['persist', 'remove'])]
    private ?Reservation $reservation = null;

    #[ORM\ManyToMany(targetEntity: Reservation::class, inversedBy: 'users')]
    private Collection $reserve;

    public function __construct()
    {
        $this->stands = new ArrayCollection();
        $this->run = new ArrayCollection();
        $this->reserve = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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
