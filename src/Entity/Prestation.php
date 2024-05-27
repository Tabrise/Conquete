<?php

namespace App\Entity;

use App\Repository\PrestationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PrestationRepository::class)]
class Prestation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\ManyToMany(targetEntity: Offre::class, inversedBy: 'prestations')]
    private Collection $idOffre;

    #[ORM\ManyToMany(targetEntity: Contrat::class, mappedBy: 'idPrestation')]
    private Collection $contrats;

    public function __construct()
    {
        $this->idOffre = new ArrayCollection();
        $this->contrats = new ArrayCollection();
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

    /**
     * @return Collection<int, Offre>
     */
    public function getIdOffre(): Collection
    {
        return $this->idOffre;
    }

    public function addIdOffre(Offre $idOffre): static
    {
        if (!$this->idOffre->contains($idOffre)) {
            $this->idOffre->add($idOffre);
        }

        return $this;
    }

    public function removeIdOffre(Offre $idOffre): static
    {
        $this->idOffre->removeElement($idOffre);

        return $this;
    }

    /**
     * @return Collection<int, Contrat>
     */
    public function getContrats(): Collection
    {
        return $this->contrats;
    }

    public function addContrat(Contrat $contrat): static
    {
        if (!$this->contrats->contains($contrat)) {
            $this->contrats->add($contrat);
            $contrat->addIdPrestation($this);
        }

        return $this;
    }

    public function removeContrat(Contrat $contrat): static
    {
        if ($this->contrats->removeElement($contrat)) {
            $contrat->removeIdPrestation($this);
        }

        return $this;
    }
}
