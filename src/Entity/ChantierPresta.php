<?php

namespace App\Entity;

use App\Repository\ChantierPrestaRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ChantierPrestaRepository::class)]
class ChantierPresta
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?float $montantPresta = null;

    #[ORM\Column(length: 150)]
    private ?string $nomPresta = null;

    #[ORM\ManyToOne(inversedBy: 'chantierPrestations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Chantier $chantier = null;

    #[ORM\ManyToOne(inversedBy: 'chantierPrestations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Poste $poste = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMontantPresta(): ?float
    {
        return $this->montantPresta;
    }

    public function setMontantPresta(?float $montantPresta): static
    {
        $this->montantPresta = $montantPresta;

        return $this;
    }

    public function getNomPresta(): ?string
    {
        return $this->nomPresta;
    }

    public function setNomPresta(string $nomPresta): static
    {
        $this->nomPresta = $nomPresta;

        return $this;
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
}
