<?php

namespace App\DataFixtures;

use App\Entity\Annonce;
use App\Entity\Reservation;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ReservationFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Récupération de toutes les annonces depuis la base de données
        $annonces = $manager->getRepository(Annonce::class)->findAll();

        // Vérifiez si des annonces existent dans la base de données
        if (empty($annonces)) {
            throw new \RuntimeException('Aucune annonce trouvée dans la base de données. Veuillez charger les fixtures des annonces avant.');
        }

        // Parcours de chaque annonce pour lui attribuer des réservations
        foreach ($annonces as $annonce) {
            // Récupération du prix de l'annonce
            $price = (float) $annonce->getPrice();

            // Générer entre 1 et 3 réservations pour chaque annonce
            $reservationCount = rand(1, 3);

            for ($i = 0; $i < $reservationCount; $i++) {
                $reservation = new Reservation();

                // Génération aléatoire des dates de réservation
                $startDate = new \DateTime(sprintf('2025-02-%02d', rand(1, 15)));
                $endDate = (clone $startDate)->modify('+'.rand(1, 7).' days');

                // Calcul des taxes et des frais de service
                $taxes = round($price * 0.15, 2); // 15% de taxes
                $serviceFees = round($price * 0.1, 2); // 10% de frais de service

                // Définir les propriétés de la réservation
                $reservation->setStartDate($startDate)
                    ->setEndDate($endDate)
                    ->setStatus('pending') // Statut par défaut
                    ->setTaxes($taxes)
                    ->setServiceFees($serviceFees)
                    ->setAnnonce($annonce) // Associer cette réservation à l'annonce
                    ->setCreatedAt(new \DateTime()) // Initialisation de createdAt
                    ->setUpdatedAt(new \DateTime()); // Initialisation de updatedAt

                // Persister la réservation
                $manager->persist($reservation);
            }
        }

        // Enregistrement des données dans la base
        $manager->flush();
    }
}
