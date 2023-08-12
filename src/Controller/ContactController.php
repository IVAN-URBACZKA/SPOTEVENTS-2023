<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact', methods: ['GET', 'POST'])]
    public function index(Request $request, MailerInterface $mailer): Response
    {
        if ($request->isMethod('POST')) {
            $formData = $request->request->all();

            $email = (new Email())
                ->from($formData['email'])
                ->to('ivan.urbaczka@gmail.com')
                ->subject('New message from contact form')
                ->text($formData['message']);

            $mailer->send($email);

            // Redirection vers une page de confirmation ou autre
            return $this->redirectToRoute('app_home');
        }

        return $this->render('contact/contact.html.twig');
    }
}
