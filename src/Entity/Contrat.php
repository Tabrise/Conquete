<?php

namespace App\Entity;

use App\Repository\ContratRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ContratRepository::class)]
class Contrat
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateCrea = null;

    #[ORM\ManyToOne(inversedBy: 'contrats')]
    private ?Societe $idSociete = null;

    #[ORM\OneToOne(mappedBy: 'idContrat', cascade: ['persist', 'remove'])]
    private ?ArticleContrat $articleContrat = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateCrea(): ?\DateTimeInterface
    {
        return $this->dateCrea;
    }

    public function setDateCrea(\DateTimeInterface $dateCrea): static
    {
        $this->dateCrea = $dateCrea;

        return $this;
    }

    public function getIdSociete(): ?Societe
    {
        return $this->idSociete;
    }

    public function setIdSociete(?Societe $idSociete): static
    {
        $this->idSociete = $idSociete;

        return $this;
    }

    public function getArticleContrat(): ?ArticleContrat
    {
        return $this->articleContrat;
    }

    public function setArticleContrat(?ArticleContrat $articleContrat): static
    {
        // unset the owning side of the relation if necessary
        if ($articleContrat === null && $this->articleContrat !== null) {
            $this->articleContrat->setIdContrat(null);
        }

        // set the owning side of the relation if necessary
        if ($articleContrat !== null && $articleContrat->getIdContrat() !== $this) {
            $articleContrat->setIdContrat($this);
        }

        $this->articleContrat = $articleContrat;

        return $this;
    }
}
