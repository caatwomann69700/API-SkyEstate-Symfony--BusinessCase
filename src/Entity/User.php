<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
#[ApiResource(
    normalizationContext: ['groups' => ['user:read']],
    denormalizationContext: ['groups' => ['user:write']],
    paginationEnabled: false
)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['user:read', 'admin:read'])]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank(message: "Le prénom est obligatoire.")]
    #[Assert\Length(max: 255, maxMessage: "Le prénom ne doit pas dépasser 255 caractères.")]
    #[Groups(['user:read', 'user:write', 'admin:read', 'admin:write'])]
    private ?string $firstname = null;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank(message: "Le nom est obligatoire.")]
    #[Assert\Length(max: 255, maxMessage: "Le nom ne doit pas dépasser 255 caractères.")]
    #[Groups(['user:read', 'user:write', 'admin:read', 'admin:write'])]
    private ?string $lastname = null;

    #[ORM\Column(type: 'string', length: 320, unique: true)]
    #[Assert\NotBlank(message: "L'email est obligatoire.")]
    #[Assert\Email(message: "L'email n'est pas valide.")]
    #[Assert\Length(max: 320, maxMessage: "L'email ne doit pas dépasser 320 caractères.")]
    #[Groups(['user:read', 'user:write', 'admin:read', 'admin:write'])]
    private ?string $email = null;

    #[ORM\Column(type: 'date')]
    #[Assert\NotBlank(message: "La date de naissance est obligatoire.")]
    #[Assert\Date(message: "La date de naissance doit être une date valide.")]
    #[Groups(['admin:read', 'admin:write'])]
    private ?\DateTimeInterface $birthdate = null;

    #[ORM\Column(type: 'string', length: 20, nullable: true)]
    #[Assert\Length(max: 20, maxMessage: "Le numéro de téléphone ne doit pas dépasser 20 caractères.")]
    #[Groups(['admin:read', 'admin:write'])]
    private ?string $phone = null;

    #[ORM\Column(type: 'json')]
    #[Groups(['admin:read', 'admin:write'])]
    private array $roles = [];

    #[ORM\Column(type: 'string')]
    #[Assert\NotBlank(message: "Le mot de passe est obligatoire.")]
    #[Assert\Length(min: 8, minMessage: "Le mot de passe doit contenir au moins 8 caractères.")]
    #[Groups(['user:write', 'admin:write'])]
    private ?string $password = null;

    #[ORM\Column(type: 'string', length: 100, nullable: true)]
    #[Assert\Length(max: 100, maxMessage: "Le genre ne doit pas dépasser 100 caractères.")]
    #[Groups(['admin:read', 'admin:write'])]
    private ?string $gender = null;

    #[ORM\Column(type: 'string', length: 45, nullable: true)]
    #[Assert\Length(max: 45, maxMessage: "Le pays ne doit pas dépasser 45 caractères.")]
    #[Groups(['admin:read', 'admin:write'])]
    private ?string $country = null;

    #[ORM\Column(type: 'string', length: 100, nullable: true)]
    #[Assert\Length(max: 100, maxMessage: "La ville ne doit pas dépasser 100 caractères.")]
    #[Groups(['admin:read', 'admin:write'])]
    private ?string $city = null;

    #[ORM\Column(type: 'datetime')]
    #[Groups(['admin:read'])]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(type: 'datetime')]
    #[Groups(['admin:read', 'admin:write'])]
    private ?\DateTimeInterface $updatedAt = null;

    #[ORM\Column(type: 'integer')]
    private int $failedAttempts = 0;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $lockUntil = null;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
        $this->roles = ['ROLE_USER'];
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;
        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;
        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function getBirthdate(): ?\DateTimeInterface
    {
        return $this->birthdate;
    }

    public function setBirthdate(\DateTimeInterface $birthdate): self
    {
        $this->birthdate = $birthdate;
        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;
        return $this;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;
        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(?string $gender): self
    {
        $this->gender = $gender;
        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(?string $country): self
    {
        $this->country = $country;
        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;
        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    public function getFailedAttempts(): int
    {
        return $this->failedAttempts;
    }

    public function setFailedAttempts(int $failedAttempts): self
    {
        $this->failedAttempts = $failedAttempts;
        return $this;
    }

    public function getLockUntil(): ?\DateTimeInterface
    {
        return $this->lockUntil;
    }

    public function setLockUntil(?\DateTimeInterface $lockUntil): self
    {
        $this->lockUntil = $lockUntil;
        return $this;
    }

    public function eraseCredentials(): void
    {
        // Si des données sensibles sont stockées temporairement, elles doivent être effacées ici
    }

    public function getUserIdentifier(): string
    {
        return $this->email;
    }
}
