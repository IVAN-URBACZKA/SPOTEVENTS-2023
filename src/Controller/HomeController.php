<?php

namespace App\Controller;

use App\Repository\EventRepository;
use App\Entity\Event;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(EventRepository $eventRepository): Response
    {

        $events =  $eventRepository->findAll();
        
        return $this->render('home/index.html.twig', [
            'events' => $events,
        ]);

    }
}
