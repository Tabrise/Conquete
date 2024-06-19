<?php

namespace App\Entity;

use App\Repository\AuditResponseRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AuditResponseRepository::class)]
class AuditResponse
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'auditResponses')]
    private ?Audit $audit = null;

    #[ORM\ManyToOne(inversedBy: 'auditResponses')]
    private ?Question $question = null;

    #[ORM\Column(length: 255)]
    private ?string $response = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAudit(): ?Audit
    {
        return $this->audit;
    }

    public function setAudit(?Audit $audit): static
    {
        $this->audit = $audit;

        return $this;
    }

    public function getQuestion(): ?Question
    {
        return $this->question;
    }

    public function setQuestion(?Question $question): static
    {
        $this->question = $question;

        return $this;
    }

    public function getResponse(): ?string
    {
        return $this->response;
    }

    public function setResponse(string $response): static
    {
        $this->response = $response;

        return $this;
    }
}
