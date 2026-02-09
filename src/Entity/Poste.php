<?php

namespace App\Entity;

use App\Repository\PosteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PosteRepository::class)]
class Poste
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 80)]
    private ?string $libelle = null;

    #[ORM\Column]
    private ?int $ordre = null;

    #[ORM\Column(nullable: true)]
    private ?float $tva = null;

    #[ORM\Column]
    private ?int $archive = null;

    /**
     * @var Collection<int, Etape>
     */
    #[ORM\OneToMany(targetEntity: Etape::class, mappedBy: 'poste')]
    private Collection $etapes;

    /**
     * @var Collection<int, ChantierPoste>
     */
    #[ORM\OneToMany(targetEntity: ChantierPoste::class, mappedBy: 'poste')]
    private Collection $chantierPostes;

    #[ORM\Column(length: 100, nullable: true)]
    private ?int $equipe = null;

    #[ORM\Column(length: 150, nullable: true)]
    private ?int $presta = null;

    /**
     * @var Collection<int, ChantierPresta>
     */
    #[ORM\OneToMany(targetEntity: ChantierPresta::class, mappedBy: 'poste')]
    private Collection $chantierPrestations;



    public function __construct()
    {
        $this->etapes = new ArrayCollection();
        $this->chantierPostes = new ArrayCollection();
        $this->chantierPrestations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): static
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getOrdre(): ?int
    {
        return $this->ordre;
    }

    public function setOrdre(int $ordre): static
    {
        $this->ordre = $ordre;

        return $this;
    }

    public function getTva(): ?float
    {
        return $this->tva;
    }

    public function setTva(?float $tva): static
    {
        $this->tva = $tva;

        return $this;
    }

    public function getArchive(): ?int
    {
        return $this->archive;
    }

    public function setArchive(int $archive): static
    {
        $this->archive = $archive;

        return $this;
    }

    /**
     * @return Collection<int, Etape>
     */
    public function getEtapes(): Collection
    {
        return $this->etapes;
    }

    public function addEtape(Etape $etape): static
    {
        if (!$this->etapes->contains($etape)) {
            $this->etapes->add($etape);
            $etape->setPoste($this);
        }

        return $this;
    }

    public function removeEtape(Etape $etape): static
    {
        if ($this->etapes->removeElement($etape)) {
           
            if ($etape->getPoste() === $this) {
                $etape->setPoste(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ChantierPoste>
     */
    public function getChantierPostes(): Collection
    {
        return $this->chantierPostes;
    }

    public function addChantierPoste(ChantierPoste $chantierPoste): static
    {
        if (!$this->chantierPostes->contains($chantierPoste)) {
            $this->chantierPostes->add($chantierPoste);
            $chantierPoste->setPoste($this);
        }

        return $this;
    }

    public function removeChantierPoste(ChantierPoste $chantierPoste): static
    {
        if ($this->chantierPostes->removeElement($chantierPoste)) {
            
            if ($chantierPoste->getPoste() === $this) {
                $chantierPoste->setPoste(null);
            }
        }

        return $this;
    }

    public function getEquipe(): ?int
    {
        return $this->equipe;
    }

    public function setEquipe(?int $equipe): static
    {
        $this->equipe = $equipe;

        return $this;
    }

    public function getPresta(): ?int
    {
        return $this->presta;
    }

    public function setPresta(?int $presta): static
    {
        $this->presta = $presta;

        return $this;
    }

        public function isEquipe(): bool
    {
        return $this->equipe === 1;
    }

    public function isPresta(): bool
    {
        return $this->presta === 1;
    }

    /**
     * @return Collection<int, ChantierPresta>
     */
    public function getChantierPrestations(): Collection
    {
        return $this->chantierPrestations;
    }

    public function addChantierPrestation(ChantierPresta $chantierPrestation): static
    {
        if (!$this->chantierPrestations->contains($chantierPrestation)) {
            $this->chantierPrestations->add($chantierPrestation);
            $chantierPrestation->setPoste($this);
        }

        return $this;
    }

    public function removeChantierPrestation(ChantierPresta $chantierPrestation): static
    {
        if ($this->chantierPrestations->removeElement($chantierPrestation)) {
           
            if ($chantierPrestation->getPoste() === $this) {
                $chantierPrestation->setPoste(null);
            }
        }

        return $this;
    } 


}
