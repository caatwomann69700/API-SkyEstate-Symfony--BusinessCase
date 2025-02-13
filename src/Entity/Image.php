<?php

namespace App\Entity;

use App\Repository\ImageRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ImageRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['image:read']],
    denormalizationContext: ['groups' => ['image:write']]
)]
class Image
{
    // Identifiant unique de l'image
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['image:read', 'annonce:read', 'category:read', 'amenity:read'])]
    private ?int $id = null;

    
    
    #[ORM\Column(length: 255)]
    #[Groups(['image:read', 'image:write', 'annonces:read', 'category:read', 'amenity:read'])] 
    private ?string $name = null;


    // Relation avec l'entité Annonce (Une annonce a une seule image principale)
    #[ORM\OneToOne(mappedBy: 'image', targetEntity: Annonce::class)]
    private ?Annonce $annonce = null;

    // Relation avec l'entité Category (Une catégorie peut avoir une image principale)
    #[ORM\OneToOne(mappedBy: 'image', targetEntity: Category::class)]
    private ?Category $category = null;

    // Relation avec l'entité Amenity (Un équipement peut avoir une icône)
    #[ORM\OneToOne(mappedBy: 'icon', targetEntity: Amenity::class)]
    private ?Amenity $amenity = null;

    // Getter pour l'ID de l'image
    public function getId(): ?int
    {
        return $this->id;
    }

    // Getter pour le nom de l'image
    public function getName(): ?string
    {
        return $this->name;
    }

    // Setter pour le nom de l'image
    public function setName(string $name): static
    {
        $this->name = $name;
        return $this;
    }

    // Getter pour l'annonce associée à l'image
    public function getAnnonce(): ?Annonce
    {
        return $this->annonce;
    }

    // Setter pour l'annonce associée
    public function setAnnonce(?Annonce $annonce): self
    {
        $this->annonce = $annonce;

        // Assurer la relation bidirectionnelle
        if ($annonce !== null && $annonce->getImage() !== $this) {
            $annonce->setImage($this);
        }

        return $this;
    }

    // Getter pour la catégorie associée à l'image
    public function getCategory(): ?Category
    {
        return $this->category;
    }

    // Setter pour la catégorie associée
    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        // Assurer la relation bidirectionnelle
        if ($category !== null && $category->getImage() !== $this) {
            $category->setImage($this);
        }

        return $this;
    }

    // Getter pour l'équipement (Amenity) associé à l'image
    public function getAmenity(): ?Amenity
    {
        return $this->amenity;
    }

    // Setter pour l'équipement associé
    public function setAmenity(?Amenity $amenity): self
    {
        $this->amenity = $amenity;

        // Assurer la relation bidirectionnelle
        if ($amenity !== null && $amenity->getIcon() !== $this) {
            $amenity->setIcon($this);
        }

        return $this;
    }
}