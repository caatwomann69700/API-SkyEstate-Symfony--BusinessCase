<?php
namespace App\WebSocket;

use App\Entity\Message;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class Chat implements MessageComponentInterface
{
    private \SplObjectStorage $clients;
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->clients = new \SplObjectStorage();
        $this->entityManager = $entityManager;
    }

    public function onOpen(ConnectionInterface $conn)
    {
        $this->clients->attach($conn);
        echo "Nouvelle connexion WebSocket ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg)
    {
        $data = json_decode($msg, true);

        if (!isset($data['content'], $data['senderId'], $data['receiverId'])) {
            echo "Message invalide reçu\n";
            return;
        }

        $sender = $this->entityManager->getRepository(User::class)->find($data['senderId']);
        $receiver = $this->entityManager->getRepository(User::class)->find($data['receiverId']);

        if (!$sender || !$receiver) {
            echo "Utilisateur non trouvé\n";
            return;
        }

        // Enregistrer le message en base de données
        $message = new Message();
        $message->setContent($data['content']);
        $message->setSender($sender);
        $message->setReceiver($receiver);

        $this->entityManager->persist($message);
        $this->entityManager->flush();

        // Diffuser le message à tous les clients connectés
        foreach ($this->clients as $client) {
            $client->send(json_encode([
                'id' => $message->getId(),
                'content' => $message->getContent(),
                'sender' => $message->getSender()->getId(),
                'receiver' => $message->getReceiver()->getId(),
                'createdAt' => $message->getCreatedAt()->format('Y-m-d H:i:s')
            ]));
        }
    }

    public function onClose(ConnectionInterface $conn)
    {
        $this->clients->detach($conn);
        echo "Connexion fermée ({$conn->resourceId})\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        echo "Erreur : {$e->getMessage()}\n";
        $conn->close();
    }
}
