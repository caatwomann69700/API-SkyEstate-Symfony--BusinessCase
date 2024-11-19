<?php

namespace App\Entity;

use App\Repository\AnnonceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: AnnonceRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['annonces:read']],
    denormalizationContext: ['groups' => ['annonces:write']]
)]
class Annonce
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['annonces:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['annonces:read', 'annonces:write'])]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['annonces:read', 'annonces:write'])]
    private ?string $description = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    #[Groups(['annonces:read', 'annonces:write'])]
    private ?string $price = null;

    #[ORM\Column(length: 255)]
    #[Groups(['annonces:read', 'annonces:write'])]
    private ?string $surface = null;

    #[ORM\Column(length: 255, nullable: false)]
    #[Groups(['annonces:read', 'annonces:write'])]
    private ?string $location = null;
    
    #[ORM\Column(length: 255)]
    #[Groups(['annonces:read', 'annonces:write'])]
    private ?string $city = null;

    #[ORM\Column(length: 20)]
    #[Groups(['annonces:read', 'annonces:write'])]
    private ?string $postalCode = null;

    #[ORM\Column(length: 255)]
    #[Groups(['annonces:read', 'annonces:write'])]
    private ?string $maxOccupants = null;

    #[ORM\Column]
    #[Groups(['annonces:read'])]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    #[Groups(['annonces:read'])]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\OneToOne(targetEntity: Image::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: true)]
    #[Groups(['annonces:read', 'annonces:write'])]
    private ?Image $image = null;

    #[ORM\ManyToOne(targetEntity: Category::class, inversedBy: 'annonces')]
    #[ORM\JoinColumn(nullable: true)]
    #[Groups(['annonces:read', 'annonces:write'])]
    private ?Category $category = null;

    #[ORM\OneToMany(mappedBy: 'annonce', targetEntity: Reservation::class, cascade: ['persist', 'remove'])]
    #[Groups(['annonces:read'])]
    private Collection $reservations;

    #[ORM\ManyToMany(targetEntity: Amenity::class, inversedBy: 'annonces')]
    #[ORM\JoinTable(name: 'annonce_amenity')]
    #[Groups(['annonces:read', 'annonces:write'])]
    private Collection $amenities;

    public function __construct()
    {
        $this->reservations = new ArrayCollection();
        $this->amenities = new ArrayCollection();
    }

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
}
