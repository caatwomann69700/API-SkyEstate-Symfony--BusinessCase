<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Entity\Annonce;
use App\Entity\Image;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['category:read']],
    denormalizationContext: ['groups' => ['category:write']]
)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['category:read', 'annonces:read'])]
    private ?int $id = null;



    #[ORM\Column(length: 255)]
    #[Groups(['category:read', 'category:write', 'annonces:read'])]
    private ?string $name = null;

    #[ORM\Column(type: 'text', nullable: true)]
    #[Groups(['category:read', 'category:write'])]
    private ?string $description = null;

    #[ORM\OneToMany(mappedBy: 'category', targetEntity: Annonce::class)]
    #[Groups(['category:read'])]
    private Collection $annonces;

    #[ORM\OneToOne(targetEntity: Image::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: true)]
    #[Groups(['category:read', 'category:write'])]
    private ?Image $image = null;

    public function __construct()
    {
        $this->annonces = new ArrayCollection();
    }


    // Getter pour l'id de la catégorie
    public function getId(): ?int
    {
        return $this->id; 
    }

    // Getter pour le nom de la catégorie
    public function getName(): ?string
    {
        return $this->name; 
    }

    // Setter pour le nom de la catégorie
    public function setName(string $name): static
    {
        $this->name = $name; 
        return $this; 
    }

    // Getter pour la description
    public function getDescription(): ?string
    {
        return $this->description; 
    }

    // Setter pour la description
    public function setDescription(?string $description): self
    {
        $this->description = $description; 
        return $this; 
    }

    // Getter pour récupérer toutes les annonces associées à la catégorie
    public function getAnnonces(): Collection
    {
        return $this->annonces; 
    }

    // Méthode pour ajouter une annonce à la catégorie
    public function addAnnonce(Annonce $annonce): self
    {
        if (!$this->annonces->contains($annonce)) { 
            $this->annonces[] = $annonce; 
            $annonce->setCategory($this); 
        }
        return $this; 
    }

    // Méthode pour retirer une annonce de la catégorie
    public function removeAnnonce(Annonce $annonce): self
    {
        if ($this->annonces->removeElement($annonce)) { 
            if ($annonce->getCategory() === $this) { 
                $annonce->setCategory(null); 
            }
        }
        return $this; 
    }

    // Getter pour récupérer l'image de la catégorie
    public function getImage(): ?Image
    {
        return $this->image; 
    }

    // Setter pour définir l'image de la catégorie
    public function setImage(?Image $image): self
    {
        $this->image = $image; 
        return $this; 
    }
}
