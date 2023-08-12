<?php

namespace App\Controller;

use App\Repository\EventRepository;
use App\Entity\Event;
use App\Form\EventType; 
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Attribute\IsGranted;



class EventController extends AbstractController
{
    #[Route('/event', name: 'app_event')]
    public function index(Request $request,EventRepository $eventRepository): Response
    {

        $filter = $request->query->get('filter', 'newest'); // Par défaut, trie par plus récent

    // Récupérez les événements triés en fonction du filtre
      $events = $eventRepository->findBy([], ['date' => $filter === 'newest' ? 'DESC' : 'ASC']);

        return $this->render('events/events.html.twig', [
            'events' => $events,
            'filter' => $filter,
        ]);
    }


    #[Route('event/{id}', name: 'single_event')]
    public function singleEvent(Request $request,$id,EventRepository $eventRepository): Response
    {
        
        $event = $eventRepository->find($id);


        return $this->render('events/event.html.twig', [
            'event' => $event,
        ]);
    }

    #[Route('/create', name: 'create_event')]
    #[IsGranted('ROLE_ADMIN')]
    public function new(Request $request, EntityManagerInterface $manager, SluggerInterface $slugger): Response
    {
        $event = new Event();

        $form = $this->createForm(EventType::class, $event);

        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {

            $photoFile = $form->get('photo')->getData();

            if ($photoFile) {
                $originalFilename = pathinfo($photoFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$photoFile->guessExtension();

                try {
                    $photoFile->move(
                        $this->getParameter('photos_directory'),
                        $newFilename
                    );

                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                $event->setPhoto($newFilename);

            
            

            $manager->persist($event);
            $manager->flush();

            return $this->redirectToRoute('app_event');
        }

       
    }

    return $this->render('events/new.html.twig', [
        'form' => $form,
    ]);
}
}