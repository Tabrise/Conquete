<?php

namespace App\Entity;

use App\Entity\EtatSociete;
use App\Repository\SocieteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: SocieteRepository::class)]
class Societe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 14, nullable: true)]
    private ?string $siret = null;

    #[ORM\Column(length: 255)]
    private ?string $adresse = null;

    #[ORM\Column(length: 14, nullable: true)]
    private ?string $numStandard = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $emailStandard = null;

    #[ORM\OneToMany(targetEntity: Contact::class, mappedBy: 'idSociete', cascade:["persist"])]
    private Collection $contacts;

    #[ORM\Column(length: 255)]
    private ?string $ville = null;

    #[ORM\Column(length: 5)]
    private ?string $codePostal = null;

    #[ORM\ManyToOne(inversedBy: 'societes')]
    private ?User $idUser = null;

    #[ORM\Column(length: 255)]
    private ?string $statut = null;

    #[ORM\Column(length: 255)]
    private ?string $secteur = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\Length(
        min: 2,
        max: 75,
        minMessage: 'Mettez un commentaire',
        maxMessage: '{{ limit }} charactère max',
    )]
    private ?string $commentaire = null;

    #[ORM\ManyToOne(inversedBy: 'societes')]
    private ?etatSociete $etat = null;

    #[ORM\OneToMany(targetEntity: Contrat::class, mappedBy: 'idSociete')]
    private Collection $contrats;

    public function __construct()
    {
        $this->contacts = new ArrayCollection();
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

    public function getSiret(): ?string
    {
        return $this->siret;
    }

    public function setSiret(?string $siret): static
    {
        $this->siret = $siret;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): static
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getNumStandard(): ?string
    {
        return $this->numStandard;
    }

    public function setNumStandard(?string $numStandard): static
    {
        $this->numStandard = $numStandard;

        return $this;
    }

    public function getEmailStandard(): ?string
    {
        return $this->emailStandard;
    }

    public function setEmailStandard(?string $emailStandard): static
    {
        $this->emailStandard = $emailStandard;

        return $this;
    }

    /**
     * @return Collection<int, Contact>
     */
    public function getContacts(): Collection
    {
        return $this->contacts;
    }

    public function addContact(Contact $contact): static
    {
        if (!$this->contacts->contains($contact)) {
            $this->contacts->add($contact);
            $contact->setIdSociete($this);
        }

        return $this;
    }

    public function removeContact(Contact $contact): static
    {
        if ($this->contacts->removeElement($contact)) {
            // set the owning side to null (unless already changed)
            if ($contact->getIdSociete() === $this) {
                $contact->setIdSociete(null);
            }
        }
        return $this;
    }
    
    public function __toString(): string
    {
        return (string)$this->getId();
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): static
    {
        $this->ville = $ville;

        return $this;
    }

    public function getCodePostal(): ?string
    {
        return $this->codePostal;
    }

    public function setCodePostal(string $codePostal): static
    {
        $this->codePostal = $codePostal;

        return $this;
    }

    public function getIdUser(): ?User
    {
        return $this->idUser;
    }

    public function setIdUser(?User $idUser): static
    {
        $this->idUser = $idUser;

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): static
    {
        $this->statut = $statut;

        return $this;
    }

    public function getSecteur(): ?string
    {
        return $this->secteur;
    }

    public function setSecteur(string $secteur): static
    {
        $this->secteur = $secteur;

        return $this;
    }

    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }

    public function setCommentaire(string $commentaire): static
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    public function getEtat(): ?EtatSociete
    {
        return $this->etat;
    }

    public function setEtat(?EtatSociete $etat): static
    {
        $this->etat = $etat;

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
            $contrat->setIdSociete($this);
        }

        return $this;
    }

    public function removeContrat(Contrat $contrat): static
    {
        if ($this->contrats->removeElement($contrat)) {
            // set the owning side to null (unless already changed)
            if ($contrat->getIdSociete() === $this) {
                $contrat->setIdSociete(null);
            }
        }

        return $this;
    }
}
