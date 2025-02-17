<?php
namespace App\State;

use ApiPlatform\State\ProviderInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use App\Entity\Annonce;

class MesAnnoncesProvider implements ProviderInterface
{
    private EntityManagerInterface $entityManager;
    private Security $security;

    public function __construct(EntityManagerInterface $entityManager, Security $security)
    {
        $this->entityManager = $entityManager;
        $this->security = $security;
    }

    public function provide(\ApiPlatform\Metadata\Operation $operation, array $uriVariables = [], array $context = []): iterable
    {
        $user = $this->security->getUser();

        if (!$user) {
            throw new \RuntimeException("Utilisateur non connecté");
        }

        return $this->entityManager->getRepository(Annonce::class)->findBy(['user' => $user]);
    }
}
