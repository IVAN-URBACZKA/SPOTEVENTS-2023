<?php

namespace App\Controller;

use App\Entity\Event;
use App\Repository\EventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;


class AdminEventController extends AbstractController
{
   
    #[Route('/admin/events', name: 'admin_events')]
    public function index(EventRepository $eventRepository)
    {
        $events = $eventRepository->findAll();

        return $this->render('admin_event/index.html.twig', [
            'events' => $events,
        ]);
    }

    
    #[Route('/admin/events/{id}/delete', name: 'admin_event_delete')]
    public function delete(Event $event,EntityManagerInterface $manager)
    {
        $manager->remove($event);
        $manager->flush();

        $this->addFlash('success', 'Event has been deleted.');

        return $this->redirectToRoute('admin_events');
    }
}
