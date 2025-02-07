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
    
    // 🔍 Log les détails du token reçu
    $this->logger->info("CurrentUserProvider: Vérification utilisateur", [
        'user' => $user ? $user->getEmail() : 'Aucun utilisateur trouvé',
        'roles' => $user ? $user->getRoles() : [],
    ]);

    if (!$user instanceof User) {
        $this->logger->warning("⚠️ Aucun utilisateur connecté !");
        return null;
    }

    return $user;
}

}
