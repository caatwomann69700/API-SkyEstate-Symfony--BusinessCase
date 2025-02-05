<?php

namespace App\Controller;

use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request; 
class UserController
{
    private Security $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }
    #[Route('/api/debug-token', name: 'api_debug_token', methods: ['GET'])]
    public function debugToken(Request $request): JsonResponse
    {
        $authorizationHeader = $request->headers->get('Authorization');
    
        return new JsonResponse([
            'Authorization Header' => $authorizationHeader,
        ]);
    }

    #[Route('/api/users/me', name: 'api_users_me', methods: ['GET'])]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function me(): JsonResponse
    {
        $user = $this->security->getUser();

        if (!$user instanceof User) {
            return new JsonResponse(['message' => 'User not found or not authenticated'], 401);
        }

        return new JsonResponse([
            'id' => $user->getId(),
            'email' => $user->getEmail(),
            'roles' => $user->getRoles(),
            'lastname' => $user->getLastname(),
            'firstname' => $user->getFirstname(),
        ]);
    }
}
