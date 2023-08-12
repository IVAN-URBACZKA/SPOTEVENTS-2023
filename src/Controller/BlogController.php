<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ArticleRepository;
use App\Entity\Article;

class BlogController extends AbstractController
{
    #[Route('/blog', name: 'app_blog')]
    public function index(ArticleRepository $ArticleRepository): Response
    {

        $articles = $ArticleRepository->findAll();

        return $this->render('blog/blog.html.twig', [
            'articles' => $articles,
        ]);
    }
}
