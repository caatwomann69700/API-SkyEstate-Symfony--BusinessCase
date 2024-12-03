<?php

namespace App\Entity;

// Importation des dépendances nécessaires pour le fonctionnement de l'entité Annonce
use App\Repository\AnnonceRepository; // Repository pour gérer les interactions avec la b
use Doctrine\Common\Collections\ArrayCollection; // Classe pour gérer des collections d'objets
use Doctrine\Common\Collections\Collection; // Interface de collection
use Doctrine\DBAL\Types\Types; // Types pour les colonnes de la base de données
use Doctrine\ORM\Mapping as ORM; // Annotations pour ORM (Doctrine)
use ApiPlatform\Metadata\ApiResource; // Annotation pour définir une ressource API
use Symfony\Component\Serializer\Annotation\Groups; // Annotation pour les groupes de sérialisation




// Définition de l'entité Annonce avec son repository associé
#[ORM\Entity(repositoryClass: AnnonceRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['annonces:read']], // Contexte de lecture pour l'API
    denormalizationContext: ['groups' => ['annonces:write']] // Contexte d'écriture pour l'API
)]

class Annonce
{
    // Identifiant unique de l'annonce (clé primaire)
    #[ORM\Id] // clé primaire
    #[ORM\GeneratedValue] // Génération automatique de l'identifiant
    #[ORM\Column] // Colonne dans la base de données
    #[Groups(['annonces:read'])] // Ce champ est inclus dans le groupe de lecture de l'API
    private ?int $id = null;

    // Titre de l'annonce
    #[ORM\Column(length: 255)] 
    #[Groups(['annonces:read', 'annonces:write'])] 
    private ?string $title = null;

    // Description de l'annonce
    #[ORM\Column(type: Types::TEXT)] 
    #[Groups(['annonces:read', 'annonces:write'])] 
    private ?string $description = null;

    // Prix de l'annonce
    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)] 
    #[Groups(['annonces:read', 'annonces:write'])] 
    private ?string $price = null;

    // Surface de l'espace proposé
    #[ORM\Column(length: 255)] 
    #[Groups(['annonces:read', 'annonces:write'])] 
    private ?string $surface = null;

    // Localisation (adresse ou lieu exact)
    #[ORM\Column(length: 255, nullable: false)] 
    #[Groups(['annonces:read', 'annonces:write'])] 
    private ?string $location = null;

    // Ville de l'annonce
    #[ORM\Column(length: 255)] 
    #[Groups(['annonces:read', 'annonces:write'])] 
    private ?string $city = null;

    // Code postal
    #[ORM\Column(length: 20)] 
    #[Groups(['annonces:read', 'annonces:write'])] 
    private ?string $postalCode = null;

    // Nombre maximal d'occupants pour l'annonce
    #[ORM\Column(length: 255)] 
    #[Groups(['annonces:read', 'annonces:write'])] 
    private ?string $maxOccupants = null;

    // Date de création de l'annonce
    #[ORM\Column] 
    #[Groups(['annonces:read'])] //  uniquement en lecture 
    private ?\DateTimeImmutable $createdAt = null;

    // Date de dernière mise à jour de l'annonce
    #[ORM\Column] 
    #[Groups(['annonces:read'])] //  uniquement en lecture
    private ?\DateTimeImmutable $updatedAt = null;

    // Image principale de l'annonce (relation OneToOne avec l'entité Image) pour les annonces qui seront presentes dans home sous forme de cards
    #[ORM\OneToOne(targetEntity: Image::class, cascade: ['persist', 'remove'])] 
    #[ORM\JoinColumn(nullable: true)] // La relation peut être nulle
    #[Groups(['annonces:read', 'annonces:write'])] 
    private ?Image $image = null;

    // Catégorie de l'annonce (relation ManyToOne avec l'entité Category)
    #[ORM\ManyToOne(targetEntity: Category::class, inversedBy: 'annonces')] // Relation inversée avec Category
    #[ORM\JoinColumn(nullable: true)] // La relation peut être nulle
    #[Groups(['annonces:read', 'annonces:write'])] // lecture et écriture
    private ?Category $category = null;

    // Réservations associées à l'annonce (relation OneToMany avec Reservation)
    #[ORM\OneToMany(mappedBy: 'annonce', targetEntity: Reservation::class, cascade: ['persist', 'remove'])] 
    #[Groups(['annonces:read'])] //  uniquement en lecture
    private Collection $reservations;

    // Équipements (amenities) associés à l'annonce (relation ManyToMany avec Amenity)
    #[ORM\ManyToMany(targetEntity: Amenity::class, inversedBy: 'annonces')]
    #[ORM\JoinTable(name: 'annonce_amenity')]
    #[Groups(['annonces:read', 'annonces:write', 'amenity:read'])] // Ajout de amenity:read
    private Collection $amenities;
    
    // Liste d'images supplémentaires pour l'annonce (relation OneToMany avec ImageList) pour la page detailé d'une annonce
    #[ORM\OneToMany(mappedBy: 'annonce', targetEntity: ImageList::class, cascade: ['persist', 'remove'])] 
    #[Groups(['annonces:read', 'annonces:write'])] 
    private Collection $imagesList;

    // Constructeur de l'entité pour initialiser les collections
    public function __construct()
    {
        $this->reservations = new ArrayCollection(); 
        $this->amenities = new ArrayCollection(); 
        $this->imagesList = new ArrayCollection(); 
    }

    // Getter et setter pour l'identifiant
    public function getId(): ?int
    {
        return $this->id;
    }

    // Getter et setter pour le titre
    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    // Getter et setter pour la description
    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    // Getter et setter pour le prix
    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): self
    {
        $this->price = $price;
        return $this;
    }

    // Getter et setter pour la surface
    public function getSurface(): ?string
    {
        return $this->surface;
    }

    public function setSurface(string $surface): self
    {
        $this->surface = $surface;
        return $this;
    }

    // Getter et setter pour la localisation
    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(string $location): self
    {
        $this->location = $location;
        return $this;
    }

    // Getter et setter pour la ville
    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;
        return $this;
    }

    // Getter et setter pour le code postal
    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    public function setPostalCode(string $postalCode): self
    {
        $this->postalCode = $postalCode;
        return $this;
    }

    // Getter et setter pour le nombre maximal d'occupants
    public function getMaxOccupants(): ?string
    {
        return $this->maxOccupants;
    }

    public function setMaxOccupants(string $maxOccupants): self
    {
        $this->maxOccupants = $maxOccupants;
        return $this;
    }

    // Getter et setter pour la date de création
    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    // Getter et setter pour la date de mise à jour
    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    // Getter et setter pour l'image principale
    public function getImage(): ?Image
    {
        return $this->image;
    }

    public function setImage(?Image $image): self
    {
        $this->image = $image;
        return $this;
    }

    // Getter et setter pour la catégorie
    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;
        return $this;
    }

    // Getter pour les réservations
    public function getReservations(): Collection
    {
        return $this->reservations;
    }

    // Ajout d'une réservation
    public function addReservation(Reservation $reservation): self
    {
        if (!$this->reservations->contains($reservation)) {
            $this->reservations[] = $reservation;
            $reservation->setAnnonce($this);
        }

        return $this;
    }

    // Suppression d'une réservation
    public function removeReservation(Reservation $reservation): self
    {
        if ($this->reservations->removeElement($reservation)) {
            if ($reservation->getAnnonce() === $this) {
                $reservation->setAnnonce(null);
            }
        }

        return $this;
    }

    // Getter pour les équipements
    public function getAmenities(): Collection
    {
        return $this->amenities;
    }

    // Ajout d'un équipement
    public function addAmenity(Amenity $amenity): self
    {
        if (!$this->amenities->contains($amenity)) {
            $this->amenities->add($amenity);
        }

        return $this;
    }

    // Suppression d'un équipement
    public function removeAmenity(Amenity $amenity): self
    {
        $this->amenities->removeElement($amenity);

        return $this;
    }

    // Getter pour les listes d'images supplémentaires
    public function getImagesList(): Collection
    {
        return $this->imagesList;
    }

    // Ajout d'une image supplémentaire
    public function addImageList(ImageList $imageList): self
    {
        if (!$this->imagesList->contains($imageList)) {
            $this->imagesList[] = $imageList;
            $imageList->setAnnonce($this);
        }

        return $this;
    }

    // Suppression d'une image supplémentaire
    public function removeImageList(ImageList $imageList): self
    {
        if ($this->imagesList->removeElement($imageList)) {
            if ($imageList->getAnnonce() === $this) {
                $imageList->setAnnonce(null);
            }
        }

        return $this;
    }
}
