<?php

namespace App\Entity;

use App\Repository\RoleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RoleRepository::class)]
class Role
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $role = null;

    #[ORM\ManyToOne(inversedBy: 'asign')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Utilisateur $utilisateur = null;

    #[ORM\OneToMany(mappedBy: 'role', targetEntity: Utilisateur::class)]
    private Collection $asign;

    public function __construct()
    {
        $this->asign = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRole(): ?int
    {
        return $this->role;
    }

    public function setRole(int $role): static
    {
        $this->role = $role;

        return $this;
    }

    public function getUtilisateur(): ?Utilisateur
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?Utilisateur $utilisateur): static
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }

    /**
     * @return Collection<int, Utilisateur>
     */
    public function getAsign(): Collection
    {
        return $this->asign;
    }

    public function addAsign(Utilisateur $asign): static
    {
        if (!$this->asign->contains($asign)) {
            $this->asign->add($asign);
            $asign->setRole($this);
        }

        return $this;
    }

    public function removeAsign(Utilisateur $asign): static
    {
        if ($this->asign->removeElement($asign)) {
            // set the owning side to null (unless already changed)
            if ($asign->getRole() === $this) {
                $asign->setRole(null);
            }
        }

        return $this;
    }
}
