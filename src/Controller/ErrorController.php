<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/{_locale<%app.supported_locales%>}')]
class ErrorController extends AbstractController
{
    #[Route('/error', name: 'app_error')]
    public function index(): Response
    {
        return $this->render('error/index.html.twig', [
        ]);
    }
}
