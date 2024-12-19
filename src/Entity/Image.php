<?php
namespace App\Entity;

use App\Repository\ImageRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ImageRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['images:read']],
)]
class Image
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['images:read', 'annonces:read', 'category:read', 'amenities:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['images:read', 'images:write', 'annonces:read', 'category:read', 'amenities:read'])]
    private ?string $name = null;

    #[ORM\OneToOne(mappedBy: 'image', targetEntity: Annonce::class)]
    private ?Annonce $annonce = null;

    #[ORM\OneToOne(mappedBy: 'image', targetEntity: Category::class)]
    private ?Category $category = null;

    #[ORM\OneToOne(mappedBy: 'icon', targetEntity: Amenity::class)] // Relation OneToOne avec Amenity
    private ?Amenity $amenity = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;
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

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;
        return $this;
    }

    public function getAmenity(): ?Amenity
    {
        return $this->amenity;
    }

    public function setAmenity(?Amenity $amenity): self
    {
        $this->amenity = $amenity;
        return $this;
    }
}
