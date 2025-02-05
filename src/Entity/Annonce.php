<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiFilter;
use App\Repository\AnnonceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Doctrine\Orm\Filter\RangeFilter;
use App\Entity\User; 
use App\Entity\Image; 


#[ORM\Entity(repositoryClass: AnnonceRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['annonces:read']],
    denormalizationContext: ['groups' => ['annonces:write']]
)]

#[ApiFilter(SearchFilter::class, properties: [
    'title' => 'partial',       // Recherche partielle dans le titre
    'description' => 'partial', // Recherche partielle dans la description
    'city' => 'exact',          // Recherche exacte par ville
    'postalCode' => 'exact',    // Recherche exacte par code postal
    'price' => 'exact',         // Recherche exacte ou range (selon le front)
    'category.name' => 'exact', // Recherche par catégorie
    'maxOccupants' => 'exact',  // Recherche par nombre d'occupants (ajouté)
])]

#[ApiFilter(RangeFilter::class, properties: ['price'])]
class Annonce
{
    // Identifiant unique de l'annonce
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['annonces:read'])]
    private ?int $id = null;

    // Titre de l'annonce
    #[ORM\Column(length: 255)]
    #[Groups(['annonces:read', 'annonces:write'])]
    private ?string $title = null;

    // Description détaillée de l'annonce
    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['annonces:read', 'annonces:write'])]
    private ?string $description = null;

    // Prix de l'annonce
    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    #[Groups(['annonces:read', 'annonces:write'])]
    private ?string $price = null;

    // Surface en m² de l'espace proposé
    #[ORM\Column(length: 255)]
    #[Groups(['annonces:read', 'annonces:write'])]
    private ?string $surface = null;

    // Adresse précise ou localisation
    #[ORM\Column(length: 255, nullable: false)]
    #[Groups(['annonces:read', 'annonces:write'])]
    private ?string $location = null;

    // Ville de l'annonce
    #[ORM\Column(length: 255)]
    #[Groups(['annonces:read', 'annonces:write'])]
    private ?string $city = null;

    // Code postal de la localisation
    #[ORM\Column(length: 20)]
    #[Groups(['annonces:read', 'annonces:write'])]
    private ?string $postalCode = null;

    // Nombre maximal d'occupants
    #[ORM\Column(length: 255)]
    #[Groups(['annonces:read', 'annonces:write'])]
    private ?string $maxOccupants = null;

    // Date de création (lecture seule)
    #[ORM\Column]
    #[Groups(['annonces:read'])]
    private ?\DateTimeImmutable $createdAt = null;

    // Dernière date de mise à jour (lecture seule)
    #[ORM\Column]
    #[Groups(['annonces:read'])]
    private ?\DateTimeImmutable $updatedAt = null;

    // Image principale de l'annonce
    // Image principale de l'annonce
    #[ORM\OneToOne(targetEntity: Image::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: true)]
    #[Groups(['annonces:read', 'annonces:write'])]  // 🔥 Ajout du bon group
    private ?Image $image = null;


    // Catégorie de l'annonce
    #[ORM\ManyToOne(targetEntity: Category::class, inversedBy: 'annonces')]
    #[ORM\JoinColumn(nullable: true)]
    #[Groups(['annonces:read', 'annonces:write'])]
    private ?Category $category = null;

    // Réservations associées
    #[ORM\OneToMany(mappedBy: 'annonce', targetEntity: Reservation::class, cascade: ['persist', 'remove'])]
    #[Groups(['annonces:read'])]
    private Collection $reservations;

    // Équipements associés
    #[ORM\ManyToMany(targetEntity: Amenity::class, inversedBy: 'annonces', fetch: 'LAZY')]

    #[ORM\JoinTable(name: 'annonce_amenity')]
    #[Groups(['annonces:read', 'annonces:write', 'amenity:read'])]
    private Collection $amenities;

    // Liste d'images supplémentaires pour la page détaillée
    #[ORM\OneToMany(mappedBy: 'annonce', targetEntity: ImageList::class, cascade: ['persist', 'remove'])]
    #[Groups(['annonces:read', 'annonces:write'])]
    private Collection $imagesList;


    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'annonces')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['annonces:read', 'annonces:write'])]
    private ?User $user = null;


    public function __construct()
    {
        $this->reservations = new ArrayCollection();
        $this->amenities = new ArrayCollection();
        $this->imagesList = new ArrayCollection();
        $this->users = new ArrayCollection(); // Initialiser la collection des utilisateurs
    }
    
    // Getter pour les utilisateurs
    public function getUser(): ?User
    {
        return $this->user;
    }
    
    public function setUser(?User $user): self
    {
        $this->user = $user;
    
        return $this;
    }

    // Ajouter un utilisateur à l'annonce
    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
        }
        return $this;
    }

    // Supprimer un utilisateur de l'annonce
    public function removeUser(User $user): self
    {
        $this->users->removeElement($user);
        return $this;
    }

    // Getters et Setters (inchangés mais vérifiés)
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): self
    {
        $this->price = $price;
        return $this;
    }

    public function getSurface(): ?string
    {
        return $this->surface;
    }

    public function setSurface(string $surface): self
    {
        $this->surface = $surface;
        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(string $location): self
    {
        $this->location = $location;
        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;
        return $this;
    }

    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    public function setPostalCode(string $postalCode): self
    {
        $this->postalCode = $postalCode;
        return $this;
    }

    public function getMaxOccupants(): ?string
    {
        return $this->maxOccupants;
    }

    public function setMaxOccupants(string $maxOccupants): self
    {
        $this->maxOccupants = $maxOccupants;
        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    public function getImage(): ?Image
    {
        return $this->image;
    }

    public function setImage(?Image $image): self
    {
        $this->image = $image;
        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;
        return $this;
    }

    public function getReservations(): Collection
    {
        return $this->reservations;
    }

    public function addReservation(Reservation $reservation): self
    {
        if (!$this->reservations->contains($reservation)) {
            $this->reservations[] = $reservation;
            $reservation->setAnnonce($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): self
    {
        if ($this->reservations->removeElement($reservation)) {
            if ($reservation->getAnnonce() === $this) {
                $reservation->setAnnonce(null);
            }
        }

        return $this;
    }

    public function getAmenities(): Collection
    {
        return $this->amenities;
    }

    public function addAmenity(Amenity $amenity): self
    {
        if (!$this->amenities->contains($amenity)) {
            $this->amenities->add($amenity);
        }

        return $this;
    }

    public function removeAmenity(Amenity $amenity): self
    {
        $this->amenities->removeElement($amenity);

        return $this;
    }

    public function getImagesList(): Collection
    {
        return $this->imagesList;
    }

    public function addImageList(ImageList $imageList): self
    {
        if (!$this->imagesList->contains($imageList)) {
            $this->imagesList[] = $imageList;
            $imageList->setAnnonce($this);
        }

        return $this;
    }

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
