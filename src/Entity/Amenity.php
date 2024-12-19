<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\ApiFilter;
use App\Repository\AmenityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;

#[ORM\Entity(repositoryClass: AmenityRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['amenity:read']],
    denormalizationContext: ['groups' => ['amenity:write']],
    paginationEnabled: true,
    paginationItemsPerPage: 10
)]
#[ApiFilter(SearchFilter::class, properties: ['name' => 'partial'])]
class Amenity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['amenity:read', 'annonce:read', 'annonce:write'])]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['amenity:read', 'amenity:write', 'annonce:read'])]
    #[Assert\NotBlank(message: 'The name cannot be blank.')]
    #[Assert\Length(
        max: 255,
        maxMessage: 'The name cannot exceed 255 characters.'
    )]
    private ?string $name = null;

    #[ORM\OneToOne(targetEntity: Image::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)] // Une image est obligatoire pour chaque amenity
    #[Groups(['amenity:read', 'amenity:write'])]
    private ?Image $icon = null;

    #[ORM\ManyToMany(targetEntity: Annonce::class, mappedBy: 'amenities', fetch: 'LAZY')]
    #[Groups(['amenity:relation_read'])]
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

    public function getIcon(): ?Image
    {
        return $this->icon;
    }

    public function setIcon(Image $icon): self
    {
        $this->icon = $icon;
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
