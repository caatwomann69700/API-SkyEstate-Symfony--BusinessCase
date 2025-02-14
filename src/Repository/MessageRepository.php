<?php

namespace App\Repository;

use App\Entity\Message;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Message>
 */
class MessageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Message::class);
    }

    // ✅ Récupère tous les messages où l'utilisateur est l'expéditeur ou le destinataire
    public function findBySenderOrReceiver(User $user): array
    {
        return $this->createQueryBuilder('m')
            ->where('m.sender = :user OR m.receiver = :user')
            ->setParameter('user', $user)
            ->orderBy('m.createdAt', 'DESC')
            ->getQuery()
            ->getResult();
    }

    // ✅ Récupère tous les messages entre deux utilisateurs
    public function findUserConversations(User $user): array
    {
        $qb = $this->createQueryBuilder('m')
            ->select('DISTINCT u.id, u.firstname, u.lastname, u.email')
            ->leftJoin('m.sender', 's')
            ->leftJoin('m.receiver', 'r')
            ->leftJoin(User::class, 'u', 'WITH', 'u.id = s.id OR u.id = r.id')
            ->where('m.sender = :user OR m.receiver = :user')
            ->andWhere('u.id != :user') // Exclure l'utilisateur actuel
            ->setParameter('user', $user)
            ->orderBy('u.firstname', 'ASC');
    
        return $qb->getQuery()->getResult();
    }

    public function findGroupedConversations(): array
{
    return $this->createQueryBuilder('m')
        ->select('DISTINCT u.id, u.firstname, u.lastname, u.email')
        ->leftJoin('m.sender', 's')
        ->leftJoin('m.receiver', 'r')
        ->leftJoin(User::class, 'u', 'WITH', 'u.id = s.id OR u.id = r.id')
        ->orderBy('u.firstname', 'ASC')
        ->getQuery()
        ->getResult();
}

public function findMessagesBetweenUsers(User $user1, User $user2): array
{
    return $this->createQueryBuilder('m')
        ->where('(m.sender = :user1 AND m.receiver = :user2) OR (m.sender = :user2 AND m.receiver = :user1)')
        ->setParameter('user1', $user1)
        ->setParameter('user2', $user2)
        ->orderBy('m.createdAt', 'ASC') 
        ->getQuery()
        ->getResult();
}


}
