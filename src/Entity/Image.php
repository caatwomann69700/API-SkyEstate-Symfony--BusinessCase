<?php

namespace App\Entity;

// Importation des classes nécessaires pour cette entité
use App\Repository\ImageRepository; // Repository pour gérer les interactions avec la base de données pour les images
use Doctrine\ORM\Mapping as ORM; // Annotations pour définir les entités et leurs propriétés dans Doctrine
use ApiPlatform\Metadata\ApiResource; // Annotation pour exposer cette entité comme une ressource API
use Symfony\Component\Serializer\Annotation\Groups; // Annotation pour définir les groupes de sérialisation
use App\Entity\Category; // Importation de l'entité Category

// Déclaration de l'entité Image et configuration pour API Platform
#[ORM\Entity(repositoryClass: ImageRepository::class)] // Associe l'entité à ImageRepository pour les interactions avec la base de données
#[ApiResource(
    normalizationContext: ['groups' => ['images:read']], // Contexte de lecture pour l'API
)]
class Image
{
    // Identifiant unique de l'image (clé primaire)
    #[ORM\Id] // Définit cet attribut comme clé primaire
    #[ORM\GeneratedValue] // L'identifiant est généré automatiquement
    #[ORM\Column] // Colonne dans la base de données
    #[Groups(['images:read', 'annonces:read', 'category:read'])] // Accessible dans ces groupes de lecture
    private ?int $id = null;

    // Nom ou chemin de l'image
    #[ORM\Column(length: 255)] // Colonne string avec une longueur maximale de 255 caractères
    #[Groups(['images:read', 'images:write', 'annonces:read', 'category:read'])] // Accessible en lecture et écriture dans ces groupes
    private ?string $name = null;

    // Relation OneToOne avec Annonce (une image peut être associée à une annonce)
    #[ORM\OneToOne(mappedBy: 'image', targetEntity: Annonce::class)] // Définit la relation inverse avec Annonce
    private ?Annonce $annonce = null;

    // Relation OneToOne avec Category (une image peut être associée à une catégorie)
    #[ORM\OneToOne(mappedBy: 'image', targetEntity: Category::class)] // Définit la relation inverse avec Category
    private ?Category $category = null;

    // Getter pour l'identifiant de l'image
    public function getId(): ?int
    {
        return $this->id; // Retourne l'identifiant de l'image
    }

    // Getter pour le nom de l'image
    public function getName(): ?string
    {
        return $this->name; // Retourne le nom de l'image
    }

    // Setter pour définir le nom de l'image
    public function setName(string $name): static
    {
        $this->name = $name; // Affecte la valeur du nom
        return $this; // Retourne l'objet courant pour le chaînage
    }

    // Getter pour récupérer l'annonce associée à cette image
    public function getAnnonce(): ?Annonce
    {
        return $this->annonce; // Retourne l'annonce associée
    }

    // Setter pour définir l'annonce associée à cette image
    public function setAnnonce(?Annonce $annonce): self
    {
        $this->annonce = $annonce; // Lie cette image à une annonce
        return $this; // Retourne l'objet courant pour le chaînage
    }

    // Getter pour récupérer la catégorie associée à cette image
    public function getCategory(): ?Category
    {
        return $this->category; // Retourne la catégorie associée
    }

    // Setter pour définir la catégorie associée à cette image
    public function setCategory(?Category $category): self
    {
        $this->category = $category; // Lie cette image à une catégorie
        return $this; // Retourne l'objet courant pour le chaînage
    }
}
