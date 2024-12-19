<?php

namespace App\Repository;

use App\Entity\Annonce;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class AnnonceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Annonce::class);
    }

    /**
     * Recherche des annonces en fonction des critères fournis.
     *
     * @param array $criteria
     * @return Annonce[]
     */
    public function findByCriteria(array $criteria): array
    {
        $qb = $this->createQueryBuilder('a');

        // Filtrer par ville si spécifié
        if (!empty($criteria['city'])) {
            $qb->andWhere('a.city = :city')
               ->setParameter('city', $criteria['city']);
        }

        // Filtrer par nombre maximum de personnes si spécifié
        if (!empty($criteria['max_occupants'])) {
            $qb->andWhere('a.maxOccupants <= :max_occupants')
               ->setParameter('max_occupants', $criteria['max_occupants']);
        }

        // Filtrer par prix maximum si spécifié
        if (!empty($criteria['price'])) {
            $qb->andWhere('a.price <= :price')
               ->setParameter('price', $criteria['price']);
        }

        // Retourner les résultats triés par prix (optionnel)
        $qb->orderBy('a.price', 'ASC');

        return $qb->getQuery()->getResult();
    }
}
