<?php

namespace App\Entity;

// Importation des classes nécessaires pour cette entité
use App\Repository\ImageListRepository; // Repository pour gérer les interactions avec la base de données
use Doctrine\ORM\Mapping as ORM; // Annotations pour la configuration des entités avec Doctrine
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;// Annotation pour définir une ressource API
use Symfony\Component\Serializer\Annotation\Groups; // Annotation pour définir des groupes de sérialisation

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
        return $this->id; // Retourne l'identifiant unique de l'image
    }

    // Getter pour le nom de l'image
    public function getName(): ?string
    {
        return $this->name; // Retourne le nom ou chemin de l'image
    }

    // Setter pour définir le nom de l'image
    public function setName(string $name): self
    {
        $this->name = $name; // Affecte le nom ou chemin de l'image
        return $this; // Retourne l'objet courant pour le chaînage des méthodes
    }

    // Getter pour récupérer l'annonce associée à l'image
    public function getAnnonce(): ?Annonce
    {
        return $this->annonce; // Retourne l'annonce associée
    }

    // Setter pour définir l'annonce associée à l'image
    public function setAnnonce(?Annonce $annonce): self
    {
        $this->annonce = $annonce; // Lie cette image à une annonce
        return $this; // Retourne l'objet courant pour le chaînage des méthodes
    }
}
