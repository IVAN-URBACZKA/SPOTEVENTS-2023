<?php

namespace App\Controller;

use App\Entity\Event;
use App\Repository\EventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ArticleRepository;
use App\Entity\Article;


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



    #[Route('/admin/articles', name: 'admin_articles')]
    public function articles(ArticleRepository $articleRepository)
    {
        $articles = $articleRepository->findAll();

        return $this->render('admin_event/articles.html.twig', [
            'articles' => $articles,
        ]);
    }


    #[Route('/admin/article/{id}/delete', name: 'admin_article_delete')]
    public function deleteArticle(Article $article, EntityManagerInterface $manager)
    {
        $manager->remove($article);
        $manager->flush();

        $this->addFlash('success', 'Article deleted successfully.');

        return $this->redirectToRoute('admin_articles');
    }
}
