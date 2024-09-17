<?php

namespace App\Entity;

use App\Repository\OffresRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OffresRepository::class)]
class Offres
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $designation = null;

    #[ORM\Column]
    private ?float $prix = null;

    #[ORM\ManyToOne(inversedBy: 'offres')]
    private ?Articles $idArticle = null;

    #[ORM\OneToOne(mappedBy: 'idOffre', cascade: ['persist', 'remove'])]
    private ?ArticleContrat $articleContrat = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDesignation(): ?string
    {
        return $this->designation;
    }

    public function setDesignation(string $designation): static
    {
        $this->designation = $designation;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): static
    {
        $this->prix = $prix;

        return $this;
    }

    public function getIdArticle(): ?Articles
    {
        return $this->idArticle;
    }

    public function setIdArticle(?Articles $idArticle): static
    {
        $this->idArticle = $idArticle;

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
            $this->articleContrat->setIdOffre(null);
        }

        // set the owning side of the relation if necessary
        if ($articleContrat !== null && $articleContrat->getIdOffre() !== $this) {
            $articleContrat->setIdOffre($this);
        }

        $this->articleContrat = $articleContrat;

        return $this;
    }
}
