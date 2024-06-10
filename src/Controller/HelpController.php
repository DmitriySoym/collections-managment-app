<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HelpController extends AbstractController
{
    #[Route('{_locale<%app.supported_locales%>}/help/{userName}', name: 'app_help')]
    public function index(Request $request, string $userName): Response
    {
        if($this->getUser() === null || $this->getUser()->getUserIdentifier() !== $userName) {

            return $this->redirectToRoute('app_main');
        }

        $searchfor = $request->query->get('searchfor') ?? '';
        $tickets = null;

        return $this->render('help/index.html.twig', [
            'searchfor' => $searchfor,
            'tickets' => $tickets,
        ]);
    }
}
