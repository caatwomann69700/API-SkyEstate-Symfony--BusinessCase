<?php

namespace App\Entity;

// Importation des classes nécessaires
use Doctrine\ORM\Mapping as ORM; // Pour configurer les propriétés de l'entité avec Doctrine
use ApiPlatform\Metadata\ApiResource; // Pour exposer cette entité comme une ressource API
use Symfony\Component\Serializer\Annotation\Groups; // Pour définir des groupes de sérialisation
use App\Entity\Annonce; // Importation de l'entité Annonce

// Déclaration de l'entité Reservation et configuration pour API Platform
#[ORM\Entity] // Indique que cette classe est une entité Doctrine
#[ApiResource(
    normalizationContext: ['groups' => ['reservation:read']], // Contexte de lecture pour l'API
    denormalizationContext: ['groups' => ['reservation:write']] // Contexte d'écriture pour l'API
)]
class Reservation
{
    // Identifiant unique de la réservation (clé primaire)
    #[ORM\Id] // Déclare cette propriété comme clé primaire
    #[ORM\GeneratedValue] // Génère automatiquement l'identifiant
    #[ORM\Column] // Colonne dans la base de données
    #[Groups(['reservation:read'])] // Accessible en lecture via ce groupe
    private ?int $id = null;

    // Date de début de la réservation
    #[ORM\Column(type: 'datetime')] // Colonne de type datetime
    #[Groups(['reservation:read', 'reservation:write'])] // Accessible en lecture et écriture via l'API
    private ?\DateTimeInterface $startDate = null;

    // Date de fin de la réservation
    #[ORM\Column(type: 'datetime')] // Colonne de type datetime
    #[Groups(['reservation:read', 'reservation:write'])] // Accessible en lecture et écriture
    private ?\DateTimeInterface $endDate = null;

    // Statut de la réservation (par exemple : confirmée, annulée)
    #[ORM\Column(length: 255)] // Colonne string avec une longueur maximale de 255 caractères
    #[Groups(['reservation:read', 'reservation:write'])] // Accessible en lecture et écriture
    private ?string $status = null;

    // Montant total de la réservation
    #[ORM\Column(type: 'decimal', precision: 10, scale: 2)] // Colonne décimale avec 2 décimales
    #[Groups(['reservation:read', 'reservation:write'])] // Accessible en lecture et écriture
    private ?string $totalAmount = null;

    // Date de création de la réservation
    #[ORM\Column(type: 'datetime')] // Colonne de type datetime
    #[Groups(['reservation:read'])] // Accessible uniquement en lecture
    private ?\DateTimeInterface $createdAt = null;

    // Date de mise à jour de la réservation
    #[ORM\Column(type: 'datetime')] // Colonne de type datetime
    #[Groups(['reservation:read'])] // Accessible uniquement en lecture
    private ?\DateTimeInterface $updatedAt = null;

    // Relation ManyToOne avec l'entité Annonce
    #[ORM\ManyToOne(targetEntity: Annonce::class, inversedBy: 'reservations')] // Relation avec l'entité Annonce
    #[ORM\JoinColumn(nullable: false)] // La relation est obligatoire (non nullable)
    #[Groups(['reservation:read', 'reservation:write'])] // Accessible en lecture et écriture
    private ?Annonce $annonce = null;

    // Getter pour l'identifiant de la réservation
    public function getId(): ?int
    {
        return $this->id; // Retourne l'identifiant unique
    }

    // Getter pour la date de début
    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate; // Retourne la date de début de la réservation
    }

    // Setter pour la date de début
    public function setStartDate(\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate; // Affecte une date de début
        return $this; // Retourne l'objet courant pour le chaînage
    }

    // Getter pour la date de fin
    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate; // Retourne la date de fin de la réservation
    }

    // Setter pour la date de fin
    public function setEndDate(\DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate; // Affecte une date de fin
        return $this; // Retourne l'objet courant pour le chaînage
    }

    // Getter pour le statut
    public function getStatus(): ?string
    {
        return $this->status; // Retourne le statut de la réservation
    }

    // Setter pour le statut
    public function setStatus(string $status): self
    {
        $this->status = $status; // Affecte un statut
        return $this; // Retourne l'objet courant pour le chaînage
    }

    // Getter pour le montant total
    public function getTotalAmount(): ?string
    {
        return $this->totalAmount; // Retourne le montant total
    }

    // Setter pour le montant total
    public function setTotalAmount(string $totalAmount): self
    {
        $this->totalAmount = $totalAmount; // Affecte un montant total
        return $this; // Retourne l'objet courant pour le chaînage
    }

    // Getter pour la date de création
    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt; // Retourne la date de création
    }

    // Setter pour la date de création
    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt; // Affecte une date de création
        return $this; // Retourne l'objet courant pour le chaînage
    }

    // Getter pour la date de mise à jour
    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt; // Retourne la date de mise à jour
    }

    // Setter pour la date de mise à jour
    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt; // Affecte une date de mise à jour
        return $this; // Retourne l'objet courant pour le chaînage
    }

    // Getter pour l'annonce associée
    public function getAnnonce(): ?Annonce
    {
        return $this->annonce; // Retourne l'annonce liée à la réservation
    }

    // Setter pour l'annonce associée
    public function setAnnonce(?Annonce $annonce): self
    {
        $this->annonce = $annonce; // Lie la réservation à une annonce
        return $this; // Retourne l'objet courant pour le chaînage
    }
}
