<?php

namespace App\Entity;

use App\Repository\AuditRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AuditRepository::class)]
class Audit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?societe $client = null;

    #[ORM\OneToMany(mappedBy: 'audit', targetEntity: AuditResponse::class, cascade: ['persist', 'remove'])]
    private Collection $auditResponses;

    public function __construct()
    {
        $this->auditResponses = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getClient(): ?societe
    {
        return $this->client;
    }

    public function setClient(?societe $client): static
    {
        $this->client = $client;

        return $this;
    }

    /**
     * @return Collection<int, AuditResponse>
     */
    public function getAuditResponses(): Collection
    {
        return $this->auditResponses;
    }

    public function addAuditResponse(AuditResponse $auditResponse): self
    {
        if (!$this->auditResponses->contains($auditResponse)) {
            $this->auditResponses[] = $auditResponse;
            $auditResponse->setAudit($this);
        }

        return $this;
    }

    public function removeAuditResponse(AuditResponse $auditResponse): self
    {
        if ($this->auditResponses->contains($auditResponse)) {
            if ($auditResponse->getAudit() === $this) {
                $auditResponse->setAudit(null);
            }
        }
        return $this;
    }
}
