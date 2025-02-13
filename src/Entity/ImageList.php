<?php

namespace App\Entity;

// Importation des classes nécessaires 
use App\Repository\ImageListRepository; 
use Doctrine\ORM\Mapping as ORM; 
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use Symfony\Component\Serializer\Annotation\Groups; 

#[ORM\Entity(repositoryClass: ImageListRepository::class)]
#[ApiResource(
    operations: [
        new GetCollection(uriTemplate: '/annonces/{id}/images', normalizationContext: ['groups' => ['imageslists:read']])
    ],
    normalizationContext: ['groups' => ['imageslists:read']],
    denormalizationContext: ['groups' => ['imageslists:write']]
)]
class ImageList
{
    // Identifiant unique de l'image
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['annonces:read', 'imageslists:read'])]
    private ?int $id = null;

    // Nom ou chemin de l'image
    #[ORM\Column(length: 255)]
    #[Groups(['annonces:read', 'imageslists:read', 'imageslists:write'])]
    private ?string $name = null;

    // Relation avec Annonce
    #[ORM\ManyToOne(targetEntity: Annonce::class, inversedBy: 'imagesList')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['imageslists:read', 'imageslists:write'])]
    private ?Annonce $annonce = null;

    // Getter pour l'identifiant de l'image
    public function getId(): ?int
    {
        return $this->id; 
    }

    // Getter pour le nom de l'image
    public function getName(): ?string
    {
        return $this->name; 
    }

    // Setter pour définir le nom de l'image
    public function setName(string $name): self
    {
        $this->name = $name; 
        return $this; 
    }

    // Getter pour récupérer l'annonce associée à l'image
    public function getAnnonce(): ?Annonce
    {
        return $this->annonce; 
    }

    // Setter pour définir l'annonce associée à l'image
    public function setAnnonce(?Annonce $annonce): self
    {
        $this->annonce = $annonce; 
        return $this; 
    }
}
