<?php

namespace App\Entity;

use App\Repository\ContratRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ContratRepository::class)]
class Contrat
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\ManyToMany(targetEntity: Prestation::class, inversedBy: 'contrats')]
    private Collection $idPrestation;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    public function __construct()
    {
        $this->idPrestation = new ArrayCollection();
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
     * @return Collection<int, Prestation>
     */
    public function getIdPrestation(): Collection
    {
        return $this->idPrestation;
    }

    public function addIdPrestation(Prestation $idPrestation): static
    {
        if (!$this->idPrestation->contains($idPrestation)) {
            $this->idPrestation->add($idPrestation);
        }

        return $this;
    }

    public function removeIdPrestation(Prestation $idPrestation): static
    {
        $this->idPrestation->removeElement($idPrestation);

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }
}
