<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use Symfony\Bundle\SecurityBundle\Security;
use App\Entity\User;
use Psr\Log\LoggerInterface;

class CurrentUserProvider implements ProviderInterface
{
    private Security $security;
    private LoggerInterface $logger;

    public function __construct(Security $security, LoggerInterface $logger)
    {
        $this->security = $security;
        $this->logger = $logger;
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        $user = $this->security->getUser();

        // Log l'utilisateur récupéré
        $this->logger->info('CurrentUserProvider: Utilisateur récupéré', [
            'user' => $user ? $user->getEmail() : 'Aucun utilisateur trouvé'
        ]);

        if (!$user instanceof User) {
            return null; // Évite de lancer une erreur 500
        }
        

        return $user;
    }
}
