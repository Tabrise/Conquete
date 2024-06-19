<?php

namespace App\Entity;

use App\Repository\QuestionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QuestionRepository::class)]
class Question
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $intitule = null;

    #[ORM\Column]
    private ?bool $utiliser = null;

    #[ORM\Column]
    private ?int $ordre = null;

    #[ORM\ManyToOne(inversedBy: 'questions')]
    private ?Theme $id_theme = null;

    #[ORM\OneToMany(targetEntity: AuditResponse::class, mappedBy: 'question')]
    private Collection $auditResponses;

    public function __construct()
    {
        $this->auditResponses = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIntitule(): ?string
    {
        return $this->intitule;
    }

    public function setIntitule(string $intitule): static
    {
        $this->intitule = $intitule;

        return $this;
    }

    public function isUtiliser(): ?bool
    {
        return $this->utiliser;
    }

    public function setUtiliser(bool $utiliser): static
    {
        $this->utiliser = $utiliser;

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

    public function getIdTheme(): ?Theme
    {
        return $this->id_theme;
    }

    public function setIdTheme(?Theme $id_theme): self
    {
        $this->id_theme = $id_theme;

        return $this;
    }

    /**
     * @return Collection<int, AuditResponse>
     */
    public function getAuditResponses(): Collection
    {
        return $this->auditResponses;
    }

    public function addAuditResponse(AuditResponse $auditResponse): static
    {
        if (!$this->auditResponses->contains($auditResponse)) {
            $this->auditResponses->add($auditResponse);
            $auditResponse->setQuestion($this);
        }

        return $this;
    }

    public function removeAuditResponse(AuditResponse $auditResponse): static
    {
        if ($this->auditResponses->removeElement($auditResponse)) {
            // set the owning side to null (unless already changed)
            if ($auditResponse->getQuestion() === $this) {
                $auditResponse->setQuestion(null);
            }
        }

        return $this;
    }
}