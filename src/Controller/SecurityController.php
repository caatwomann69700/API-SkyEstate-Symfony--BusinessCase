<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class SecurityController extends AbstractController
{
    #[Route('/api/register', name: 'api_register', methods: ['POST'])]
public function register(
    Request $request,
    UserPasswordHasherInterface $passwordHasher,
    EntityManagerInterface $entityManager,
    ValidatorInterface $validator
): JsonResponse {
    $data = json_decode($request->getContent(), true);

    // Valider les données reçues
    $user = new User();
    $user->setLastname($data['lastname'] ?? ''); // Assurez-vous que ce champ est fourni
    $user->setFirstname($data['firstname'] ?? ''); // Assurez-vous que ce champ est fourni
    $user->setEmail($data['email'] ?? '');
    $birthdate = isset($data['birthdate']) ? \DateTime::createFromFormat('Y-m-d', $data['birthdate']) : null;

if (!$birthdate && isset($data['birthdate'])) {
    return $this->json(['message' => 'Invalid date format. Please use DD-MM-YYYY.'], JsonResponse::HTTP_BAD_REQUEST);
}

$user->setBirthdate($birthdate);

    $user->setPhone($data['phone'] ?? null); // Champ optionnel
    $user->setGender($data['gender'] ?? null); // Optionnel
    $user->setAddress($data['address'] ?? null); // Optionnel
    $user->setCity($data['city'] ?? null); // Optionnel
    $user->setCountry($data['country'] ?? null); // Optionnel
    $user->setPassword($passwordHasher->hashPassword($user, $data['password'] ?? ''));
    $user->setRoles(['ROLE_USER']); // Rôle par défaut
    $user->setCreatedAt(new \DateTime());
    $user->setUpdatedAt(new \DateTime());

    // Valider l'entité User
    $errors = $validator->validate($user);

    if (count($errors) > 0) {
        return $this->json($errors, JsonResponse::HTTP_BAD_REQUEST);
    }

    // Sauvegarder l'utilisateur
    $entityManager->persist($user);
    $entityManager->flush();

    return $this->json(['message' => 'User registered successfully!'], JsonResponse::HTTP_CREATED);
}

#[Route('/api/users/me', name: 'get_user_details', methods: ['GET'])]
public function getUserDetails(): JsonResponse
{
    $user = $this->getUser();

    if (!$user) {
        // Log pour vérifier si aucun utilisateur n'est chargé
        return $this->json(['error' => 'User not authenticated'], JsonResponse::HTTP_UNAUTHORIZED);
    }

    // Log pour vérifier les détails de l'utilisateur
    return $this->json($user, JsonResponse::HTTP_OK, [], ['groups' => ['user:read']]);
}


#[Route('/api/users/{id}', name: 'update_user', methods: ['PUT'])]
public function updateUser(
    int $id,
    Request $request,
    UserPasswordHasherInterface $passwordHasher,
    EntityManagerInterface $entityManager
): JsonResponse {
    $user = $entityManager->getRepository(User::class)->find($id);

    if (!$user) {
        return $this->json(['error' => 'User not found'], JsonResponse::HTTP_NOT_FOUND);
    }

    $data = json_decode($request->getContent(), true);

    // Met à jour les coordonnées utilisateur
    $user->setFirstname($data['firstname'] ?? $user->getFirstname());
    $user->setLastname($data['lastname'] ?? $user->getLastname());
    $user->setAddress($data['address'] ?? $user->getAddress());
    $user->setCity($data['city'] ?? $user->getCity());
    $user->setCountry($data['country'] ?? $user->getCountry());
    $user->setBirthdate(isset($data['birthdate']) ? new \DateTime($data['birthdate']) : $user->getBirthdate());

    // Gère le mot de passe
    if (!empty($data['old_password']) && !empty($data['new_password'])) {
        if ($passwordHasher->isPasswordValid($user, $data['old_password'])) {
            $user->setPassword($passwordHasher->hashPassword($user, $data['new_password']));
        } else {
            return $this->json(['error' => 'Invalid old password'], JsonResponse::HTTP_BAD_REQUEST);
        }
    }

    $entityManager->flush();

    return $this->json(['message' => 'User updated successfully'], JsonResponse::HTTP_OK);
}

}
