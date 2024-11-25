<?php

namespace App\Entity;

// Importation des classes nécessaires pour cette entité
use App\Repository\CategoryRepository; // Le repository pour les opérations sur la base de données
use Doctrine\ORM\Mapping as ORM; // Pour les annotations ORM (Object Relational Mapping)
use ApiPlatform\Metadata\ApiResource; // Pour exposer l'entité comme une ressource API
use Symfony\Component\Serializer\Annotation\Groups; // Pour les groupes de sérialisation/désérialisation
use Doctrine\Common\Collections\ArrayCollection; // Pour gérer des collections d'objets
use Doctrine\Common\Collections\Collection; // Interface pour les collections
use App\Entity\Annonce; // Importation de l'entité Annonce
use App\Entity\Image; // Importation de l'entité Image

// Déclaration de l'entité Category et configuration pour API Platform
#[ORM\Entity(repositoryClass: CategoryRepository::class)] // Indique que cette entité utilise CategoryRepository
#[ApiResource(
    normalizationContext: ['groups' => ['category:read']], // Définition du groupe pour lire les données via API
    denormalizationContext: ['groups' => ['category:write']] // Définition du groupe pour écrire les données via API
)]
class Category
{
    // Clé primaire de l'entité Category
    #[ORM\Id] // Indique que c'est la clé primaire
    #[ORM\GeneratedValue] // L'identifiant est généré automatiquement
    #[ORM\Column] // Colonne dans la base de données
    #[Groups(['category:read', 'annonces:read'])] // Accessible en lecture via ces groupes
    private ?int $id = null;

    // Nom de la catégorie
    #[ORM\Column(length: 255)] // Colonne string avec une longueur maximale de 255 caractères
    #[Groups(['category:read', 'category:write', 'annonces:read'])] // Accessible en lecture et écriture
    private ?string $name = null;

    // Description de la catégorie (facultatif)
    #[ORM\Column(type: 'text', nullable: true)] // Colonne texte pouvant être nulle
    #[Groups(['category:read', 'category:write'])] // Accessible en lecture et écriture
    private ?string $description = null;

    // Relation OneToMany avec Annonce (une catégorie peut avoir plusieurs annonces)
    #[ORM\OneToMany(mappedBy: 'category', targetEntity: Annonce::class)] // Définit la relation avec l'entité Annonce
    #[Groups(['category:read'])] // Accessible uniquement en lecture
    private Collection $annonces;

    // Relation OneToOne avec Image (une catégorie peut avoir une image principale)
    #[ORM\OneToOne(targetEntity: Image::class, cascade: ['persist', 'remove'])] // Cascade pour persister ou supprimer l'image
    #[ORM\JoinColumn(nullable: true)] // La relation peut être nulle
    #[Groups(['category:read', 'category:write'])] // Accessible en lecture et écriture
    private ?Image $image = null;

    // Constructeur de la classe pour initialiser les collections
    public function __construct()
    {
        $this->annonces = new ArrayCollection(); // Initialise les annonces en tant que collection
    }

    // Getter pour l'id de la catégorie
    public function getId(): ?int
    {
        return $this->id; // Retourne l'id de la catégorie
    }

    // Getter pour le nom de la catégorie
    public function getName(): ?string
    {
        return $this->name; // Retourne le nom
    }

    // Setter pour le nom de la catégorie
    public function setName(string $name): static
    {
        $this->name = $name; // Affecte la valeur du nom
        return $this; // Retourne l'objet courant pour le chaînage
    }

    // Getter pour la description
    public function getDescription(): ?string
    {
        return $this->description; // Retourne la description
    }

    // Setter pour la description
    public function setDescription(?string $description): self
    {
        $this->description = $description; // Affecte la valeur de la description
        return $this; // Retourne l'objet courant pour le chaînage
    }

    // Getter pour récupérer toutes les annonces associées à la catégorie
    public function getAnnonces(): Collection
    {
        return $this->annonces; // Retourne la collection d'annonces
    }

    // Méthode pour ajouter une annonce à la catégorie
    public function addAnnonce(Annonce $annonce): self
    {
        if (!$this->annonces->contains($annonce)) { // Vérifie si l'annonce n'est pas déjà dans la collection
            $this->annonces[] = $annonce; // Ajoute l'annonce
            $annonce->setCategory($this); // Lie cette catégorie à l'annonce
        }
        return $this; // Retourne l'objet courant pour le chaînage
    }

    // Méthode pour retirer une annonce de la catégorie
    public function removeAnnonce(Annonce $annonce): self
    {
        if ($this->annonces->removeElement($annonce)) { // Supprime l'annonce de la collection
            if ($annonce->getCategory() === $this) { // Vérifie si l'annonce est bien liée à cette catégorie
                $annonce->setCategory(null); // Supprime la liaison avec la catégorie
            }
        }
        return $this; // Retourne l'objet courant pour le chaînage
    }

    // Getter pour récupérer l'image de la catégorie
    public function getImage(): ?Image
    {
        return $this->image; // Retourne l'image associée
    }

    // Setter pour définir l'image de la catégorie
    public function setImage(?Image $image): self
    {
        $this->image = $image; // Affecte une image à la catégorie
        return $this; // Retourne l'objet courant pour le chaînage
    }
}
