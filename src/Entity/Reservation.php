<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;

#[ApiFilter(SearchFilter::class, properties: ['annonce' => 'exact'])] 

#[ORM\Entity]
#[ORM\HasLifecycleCallbacks]
#[ApiResource(
    normalizationContext: ['groups' => ['reservation:read']],
    denormalizationContext: ['groups' => ['reservation:write']]
)]
class Reservation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['reservation:read'])]
    private ?int $id = null;

    #[ORM\Column(type: 'datetime')]
    #[Groups(['reservation:read', 'reservation:write'])]
    #[Assert\NotBlank]
    private ?\DateTime $startDate = null;

    #[ORM\Column(type: 'datetime')]
    #[Groups(['reservation:read', 'reservation:write'])]
    #[Assert\NotBlank]
    private ?\DateTime $endDate = null;

    #[ORM\Column(length: 255)]
    #[Groups(['reservation:read', 'reservation:write'])]
    #[Assert\Choice(choices: ['pending', 'confirmed', 'canceled'], message: 'Invalid status.')]
    private ?string $status = null;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2)]
    #[Groups(['reservation:read', 'reservation:write'])]
    #[Assert\PositiveOrZero]
    private ?float $taxes = null;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2)]
    #[Groups(['reservation:read', 'reservation:write'])]
    #[Assert\PositiveOrZero]
    private ?float $serviceFees = null;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2)]
    #[Groups(['reservation:read'])]
    private ?float $totalAmount = null;

    #[ORM\Column(type: 'datetime')]
    #[Groups(['reservation:read'])]
    private ?\DateTime $createdAt = null;

    #[ORM\Column(type: 'datetime')]
    #[Groups(['reservation:read'])]
    private ?\DateTime $updatedAt = null;

    #[ORM\ManyToOne(targetEntity: Annonce::class, inversedBy: 'reservations')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['reservation:read', 'reservation:write'])]
    private ?Annonce $annonce = null;

    #[ORM\PrePersist]
    public function setCreatedAtValue(): void
    {
        $this->createdAt = new \DateTime();
        $this->updatedAt = $this->createdAt; 
    }

    #[ORM\PreUpdate]
    public function setUpdatedAtValue(): void
    {
        $this->updatedAt = new \DateTime();
    }

    #[ORM\PrePersist]
    #[ORM\PreUpdate]
    public function calculateTotalAmount(): void
    {
        if ($this->annonce && $this->taxes !== null && $this->serviceFees !== null) {
            $this->totalAmount = $this->annonce->getPrice() + $this->taxes + $this->serviceFees;
        }
    }

    // Getters et Setters

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartDate(): ?\DateTime
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTime $startDate): self
    {
        $this->startDate = $startDate;
        return $this;
    }

    public function getEndDate(): ?\DateTime
    {
        return $this->endDate;
    }

    public function setEndDate(\DateTime $endDate): self
    {
        $this->endDate = $endDate;
        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;
        return $this;
    }

    public function getTaxes(): ?float
    {
        return $this->taxes;
    }

    public function setTaxes(float $taxes): self
    {
        $this->taxes = $taxes;
        return $this;
    }

    public function getServiceFees(): ?float
    {
        return $this->serviceFees;
    }

    public function setServiceFees(float $serviceFees): self
    {
        $this->serviceFees = $serviceFees;
        return $this;
    }

    public function getTotalAmount(): ?float
    {
        return $this->totalAmount;
    }

    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTime $updatedAt): self
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    public function getAnnonce(): ?Annonce
    {
        return $this->annonce;
    }

    public function setAnnonce(?Annonce $annonce): self
    {
        $this->annonce = $annonce;
        return $this;
    }
}
