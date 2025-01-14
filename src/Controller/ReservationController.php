<?php
// src/Controller/ReservationController.php
namespace App\Controller;

use App\Entity\Reservation;
use App\Repository\AnnonceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class ReservationController extends AbstractController
{
    // Endpoint pour créer une réservation
    #[Route('/api/reservations', name: 'create_reservation', methods: ['POST'])]
    public function createReservation(Request $request, AnnonceRepository $annonceRepository, EntityManagerInterface $entityManager, Security $security): JsonResponse
    {
        // Vérifier si l'utilisateur est authentifié
        if (!$security->isGranted('IS_AUTHENTICATED_FULLY')) {
            return new JsonResponse(['error' => 'User not authenticated'], 401);
        }

        $data = json_decode($request->getContent(), true);
        $annonce = $annonceRepository->find($data['annonce_id']);

        if (!$annonce) {
            return new JsonResponse(['error' => 'Annonce not found'], 404);
        }

        $reservation = new Reservation();
        $reservation->setStartDate(new \DateTime($data['start_date']));
        $reservation->setEndDate(new \DateTime($data['end_date']));
        $reservation->setStatus('confirmed'); // Le statut par défaut de la réservation
        $reservation->setTotalAmount($data['total_amount']);
        $reservation->setAnnonce($annonce);
        $reservation->setCreatedAt(new \DateTime());
        $reservation->setUpdatedAt(new \DateTime());

        $entityManager->persist($reservation);
        $entityManager->flush();

        return new JsonResponse(['message' => 'Reservation created successfully'], 201);
    }
}
