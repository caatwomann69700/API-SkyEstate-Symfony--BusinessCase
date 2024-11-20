<?php

namespace App\Entity;

use App\Repository\ImageListRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ImageListRepository::class)]
class ImageList
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['annonces:read', 'annonces:write'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['annonces:read', 'annonces:write'])]
    private ?string $name = null;

    #[ORM\ManyToOne(targetEntity: Annonce::class, inversedBy: 'imagesList')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['annonces:read', 'annonces:write'])]
    private ?Annonce $annonce = null;

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

    public function getAnnonce(): ?Annonce
    {
        return $this->annonce;
    }

    public function setAnnonce(?Annonce $annonce): self
    {
        $this->annonce = $annonce;
        return $this;
    }
}
