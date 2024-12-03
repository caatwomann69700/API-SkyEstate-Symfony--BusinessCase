<?php
namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\AmenityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: AmenityRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['amenity:read']], // Lecture pour l'API
    denormalizationContext: ['groups' => ['amenity:write']] // Écriture pour l'API
)]
class Amenity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['amenity:read', 'annonce:read', 'annonce:write'])]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['amenity:read', 'amenity:write', 'annonce:read'])]
    private ?string $name = null;

    #[ORM\Column(type: 'text', nullable: true)]
    #[Groups(['amenity:read', 'amenity:write', 'annonce:read'])]
    private ?string $description = null;

    #[ORM\ManyToMany(targetEntity: Annonce::class, mappedBy: 'amenities')]
    #[Groups(['amenity:read'])]
    private Collection $annonces;

    public function __construct()
    {
        $this->annonces = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return Collection<int, Annonce>
     */
    public function getAnnonces(): Collection
    {
        return $this->annonces;
    }

    public function addAnnonce(Annonce $annonce): self
    {
        if (!$this->annonces->contains($annonce)) {
            $this->annonces->add($annonce);
            $annonce->addAmenity($this);
        }

        return $this;
    }

    public function removeAnnonce(Annonce $annonce): self
    {
        if ($this->annonces->removeElement($annonce)) {
            $annonce->removeAmenity($this);
        }

        return $this;
    }
}
