<?php

namespace App\Entity;

use App\Repository\ArticleContratRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ArticleContratRepository::class)]
class ArticleContrat
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'articleContrat', cascade: ['persist', 'remove'])]
    private ?Contrat $idContrat = null;

    #[ORM\OneToOne(inversedBy: 'articleContrat', cascade: ['persist', 'remove'])]
    private ?Offres $idOffre = null;

    #[ORM\Column]
    private ?int $qte = null;

    #[ORM\Column]
    private ?float $prix_tt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdContrat(): ?Contrat
    {
        return $this->idContrat;
    }

    public function setIdContrat(?Contrat $idContrat): static
    {
        $this->idContrat = $idContrat;

        return $this;
    }

    public function getIdOffre(): ?Offres
    {
        return $this->idOffre;
    }

    public function setIdOffre(?Offres $idOffre): static
    {
        $this->idOffre = $idOffre;

        return $this;
    }

    public function getQte(): ?int
    {
        return $this->qte;
    }

    public function setQte(int $qte): static
    {
        $this->qte = $qte;

        return $this;
    }

    public function getPrixTt(): ?float
    {
        return $this->prix_tt;
    }

    public function setPrixTt(float $prix_tt): static
    {
        $this->prix_tt = $prix_tt;

        return $this;
    }
}
