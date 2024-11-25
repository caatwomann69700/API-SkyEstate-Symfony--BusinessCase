<?php

namespace App\Entity;

// Importation des dépendances nécessaires pour l'entité Amenity
use ApiPlatform\Metadata\ApiResource; // Annotation pour exposer l'entité comme une ressource API
use App\Repository\AmenityRepository; // Repository associé à l'entité Amenity pour gérer les interactions avec la base de données
use Doctrine\Common\Collections\ArrayCollection; // Classe permettant de gérer une collection d'objets
use Doctrine\Common\Collections\Collection; // Interface pour manipuler des collections
use Doctrine\ORM\Mapping as ORM; // Annotations pour la configuration des entités dans Doctrine
use Symfony\Component\Serializer\Annotation\Groups; // Annotation pour définir des groupes de sérialisation et désérialisation

// Déclaration de l'entité Amenity et sa configuration en tant que ressource API
#[ORM\Entity(repositoryClass: AmenityRepository::class)] // Association l'entité au repository AmenityRepository
#[ApiResource(
    normalizationContext: ['groups' => ['amenity:read']], //  lecture pour l'API
    denormalizationContext: ['groups' => ['amenity:write']] //  écriture pour l'API
)]
class Amenity
{
    // Identifiant unique pour chaque équipement (clé primaire)
    #[ORM\Id] // Déclare cet attribut comme clé primaire
    #[ORM\GeneratedValue] // Génère automatiquement l'identifiant
    #[ORM\Column(type: 'integer')] // Type de la colonne dans la base de données (INT)
    #[Groups(['amenity:read', 'annonce:read', 'annonce:write'])] // lecture ET écriture via API 
    private ?int $id = null;

    // Nom de l'équipement
    #[ORM\Column(type: 'string', length: 255)] // Colonne de type string avec une longueur maximale de 255 caractères
    #[Groups(['amenity:read', 'amenity:write', 'annonce:read'])] // Inclut le champ dans les groupes de lecture et d'écriture
    private ?string $name = null;

    // Description optionnelle de l'équipement
    #[ORM\Column(type: 'text', nullable: true)] // Colonne de type texte, pouvant être nulle
    #[Groups(['amenity:read', 'amenity:write'])] //  en lecture et écriture via l'API
    private ?string $description = null;

    // Relation ManyToMany entre Amenity et Annonce
    #[ORM\ManyToMany(targetEntity: Annonce::class, mappedBy: 'amenities')] // Relation définie dans l'entité Annonce
    #[Groups(['amenity:read'])] //  uniquement en lecture
    private Collection $annonces; // Collection contenant les annonces associées à cet équipement

    // Constructeur pour initialiser les collections
    public function __construct()
    {
        $this->annonces = new ArrayCollection(); // Initialisation de la collection annonces
    }

    // Getter pour récupérer l'identifiant
    public function getId(): ?int
    {
        return $this->id;
    }

    // Getter pour récupérer le nom de l'équipement
    public function getName(): ?string
    {
        return $this->name;
    }

    // Setter pour définir le nom de l'équipement
    public function setName(string $name): self
    {
        $this->name = $name; // Affecte la valeur donnée au nom
        return $this; // Retourne l'objet lui-même pour le chaînage des méthodes
    }

    // Getter pour récupérer la description de l'équipement
    public function getDescription(): ?string
    {
        return $this->description;
    }

    // Setter pour définir la description de l'équipement
    public function setDescription(?string $description): self
    {
        $this->description = $description; // Affecte la valeur donnée à la description
        return $this; // Retourne l'objet lui-même pour le chaînage des méthodes
    }

    /**
     * @return Collection<int, Annonce> // Retourne une collection d'annonces associées à cet équipement
     */
    public function getAnnonces(): Collection
    {
        return $this->annonces; // Retourne la collection des annonces
    }

    // Méthode pour ajouter une annonce à la collection
    public function addAnnonce(Annonce $annonce): self
    {
        if (!$this->annonces->contains($annonce)) { // Vérifie si l'annonce n'est pas déjà présente
            $this->annonces->add($annonce); // Ajoute l'annonce à la collection
            $annonce->addAmenity($this); // Ajoute cet équipement à l'annonce
        }
        return $this; // Retourne l'objet lui-même pour le chaînage des méthodes
    }

    // Méthode pour retirer une annonce de la collection
    public function removeAnnonce(Annonce $annonce): self
    {
        if ($this->annonces->removeElement($annonce)) { // Supprime l'annonce de la collection
            $annonce->removeAmenity($this); // Supprime cet équipement de l'annonce
        }
        return $this; // Retourne l'objet lui-même pour le chaînage des méthodes
    }
}
