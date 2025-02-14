<?php

namespace App\Controller;

use App\Entity\Message;
use App\Entity\User;
use App\Repository\MessageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/api')]
class MessageController extends AbstractController
{
    #[Route('/messages/conversations', name: 'get_conversations', methods: ['GET'])]

    
    public function getUserConversations(MessageRepository $messageRepository): JsonResponse
    {
        $user = $this->getUser();
        
        $messages = $messageRepository->findBySenderOrReceiver($user);

        $users = [];
        foreach ($messages as $message) {
            $otherUser = ($message->getSender() === $user) ? $message->getReceiver() : $message->getSender();
            if (!isset($users[$otherUser->getId()])) {
                $users[$otherUser->getId()] = [
                    'id' => $otherUser->getId(),
                    'firstname' => $otherUser->getFirstname(),
                    'lastname' => $otherUser->getLastname(),
                    'email' => $otherUser->getEmail()
                ];
            }
        }

        return $this->json(array_values($users));
    }

    #[Route('/messages/send', name: 'send_message', methods: ['POST'])]
    #[IsGranted('ROLE_USER')]
    public function sendMessage(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $currentUser = $this->getUser();
        $receiver = $entityManager->getRepository(User::class)->find($data['receiverId']);

        if (!$receiver) {
            return $this->json(['error' => 'Utilisateur non trouvé'], 404);
        }

        $message = new Message();
        $message->setSender($currentUser);
        $message->setReceiver($receiver);
        $message->setContent($data['content']);
        $message->setCreatedAt(new \DateTimeImmutable());

        $entityManager->persist($message);
        $entityManager->flush();

        return $this->json(['success' => 'Message envoyé'], 201);
    }

    #[Route('/messages/chat/{userId}', name: 'get_chat_messages', methods: ['GET'])]
    #[IsGranted('ROLE_USER')]
    public function getChatMessages(MessageRepository $messageRepository, EntityManagerInterface $entityManager, int $userId): JsonResponse
    {
        $currentUser = $this->getUser();
        $otherUser = $entityManager->getRepository(User::class)->find($userId);

        if (!$otherUser) {
            return $this->json(['error' => 'Utilisateur non trouvé'], 404);
        }

        $messages = $messageRepository->findMessagesBetweenUsers($currentUser, $otherUser);

        return $this->json($messages, 200, [], ['groups' => 'message:read']);
    }

    #[Route('/messages/conversations/all', name: 'get_all_conversations', methods: ['GET'])]
    // #[IsGranted('ROLE_ADMIN')]
    public function getAllConversations(MessageRepository $messageRepository): JsonResponse
    {
        $conversations = $messageRepository->findGroupedConversations();

        return $this->json($conversations);
    }
}
