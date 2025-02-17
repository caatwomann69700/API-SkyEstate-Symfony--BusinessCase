<?php
namespace App\State;

use ApiPlatform\State\ProviderInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use App\Entity\Annonce;

class CurrentUserAnnonceProvider implements ProviderInterface
{
    private $entityManager;
    private $security;

    public function __construct(EntityManagerInterface $entityManager, Security $security)
    {
        $this->entityManager = $entityManager;
        $this->security = $security;
    }

    public function provide(\ApiPlatform\Metadata\Operation $operation, array $uriVariables = [], array $context = []): array
    {
        $user = $this->security->getUser();

        if (!$user) {
            return [];
        }

        return $this->entityManager->getRepository(Annonce::class)
            ->findBy(['user' => $user]);
    }
}
