<?php

namespace App\Entity;

use App\Repository\ChantierPosteRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ChantierPosteRepository::class)]
class ChantierPoste
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'chantierPostes')]
    private ?Chantier $chantier = null;

    #[ORM\ManyToOne(inversedBy: 'chantierPostes')]
    private ?Poste $poste = null;

  
    #[ORM\Column(name: 'montant_ht', type: 'float', nullable: true)]
    private ?float $montantHT = null;


    #[ORM\Column(name: 'montant_ttc', type: 'float', nullable: true)]
    private ?float $montantTTC = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getChantier(): ?Chantier
    {
        return $this->chantier;
    }

    public function setChantier(?Chantier $chantier): static
    {
        $this->chantier = $chantier;
        return $this;
    }

    public function getPoste(): ?Poste
    {
        return $this->poste;
    }

    public function setPoste(?Poste $poste): static
    {
        $this->poste = $poste;
        return $this;
    }

    public function getMontantHT(): ?float
    {
        return $this->montantHT;
    }

    public function setMontantHT(?float $montantHT): static
    {
        $this->montantHT = $montantHT;
        return $this;
    }

    public function getMontantTTC(): ?float
    {
        return $this->montantTTC;
    }

    public function setMontantTTC(?float $montantTTC): static
    {
        $this->montantTTC = $montantTTC;
        return $this;
    }
}
