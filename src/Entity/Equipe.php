<?php

namespace App\Entity;

use App\Repository\EquipeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EquipeRepository::class)]
class Equipe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $nom = null;

    #[ORM\Column(nullable: true)]
    private ?float $montantMo = null;

    /**
     * @var Collection<int, ChantierPresta>
     */
    #[ORM\OneToMany(targetEntity: ChantierPresta::class, mappedBy: 'equipe')]
    private Collection $chantiersPresta;

    /**
     * @var Collection<int, chantier>
     */
    #[ORM\OneToMany(targetEntity: chantier::class, mappedBy: 'equipe')]
    private Collection $equipe;

    #[ORM\Column(nullable: true)]
    private ?float $indice = null;
    
    public function __construct()
    {
        $this->chantiersPresta = new ArrayCollection();
        $this->chantiers = new ArrayCollection();
        $this->equipe = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getMontantMo(): ?float
    {
        return $this->montantMo;
    }

    public function setMontantMo(?float $montantMo): static
    {
        $this->montantMo = $montantMo;

        return $this;
    }

    /**
     * @return Collection<int, ChantierPresta>
     */
    public function getChantiersPresta(): Collection
    {
        return $this->chantiersPresta;
    }

    public function addChantierPresta(ChantierPresta $chantierPresta): static
    {
        if (!$this->chantiersPresta->contains($chantierPresta)) {
            $this->chantiersPresta->add($chantierPresta);
            $chantierPresta->setEquipe($this);
        }

        return $this;
    }

    public function removeChantierPresta(ChantierPresta $chantierPresta): static
    {
        if ($this->chantiersPresta->removeElement($chantierPresta)) {
            // set the owning side to null (unless already changed)
            if ($chantierPresta->getEquipe() === $this) {
                $chantierPresta->setEquipe(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, chantier>
     */
    public function getequipe(): Collection
    {
        return $this->equipe;
    }

    public function addEquipe(chantier $equipe): static
    {
        if (!$this->equipe->contains($equipe)) {
            $this->equipe->add($equipe);
            $equipe->setEquipe($this);
        }

        return $this;
    }

    public function removeEquipe(chantier $equipe): static
    {
        if ($this->equipe->removeElement($equipe)) {
            // set the owning side to null (unless already changed)
            if ($equipe->getEquipe() === $this) {
                $equipe->setEquipe(null);
            }
        }

        return $this;
    }

    public function getIndice(): ?float
    {
        return $this->indice;
    }

    public function setIndice(?float $indice): static
    {
        $this->indice = $indice;

        return $this;
    }
}