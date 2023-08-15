<?php

// src/Controller/FavoriteController.php
namespace App\Controller;

use App\Entity\Event;
use App\Repository\EventRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FavoriteController extends AbstractController
{
    
    #[Route('/update-favorite/{id}/{status}', name:'update_favorite' )]
    public function updateFavoriteStatus(
        $id,
        $status,
        EventRepository $eventRepository,
        EntityManagerInterface $entityManager
    ): JsonResponse {
        $event = $eventRepository->find($id);

        if (!$event) {
            return new JsonResponse(['success' => false, 'message' => 'Événement non trouvé.'], Response::HTTP_NOT_FOUND);
        }

        // Mettre à jour l'état de favori de l'événement
        $event->setIsFavorite($status);
        $entityManager->flush();

        return new JsonResponse(['success' => true, 'message' => 'État de favori mis à jour.']);
    }
}
