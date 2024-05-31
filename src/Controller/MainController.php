<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\CategoryRepository;

#[Route('/{_locale<%app.supported_locales%>}')]
class MainController extends AbstractController
{

        public function __construct(
        private CategoryRepository $cr,
    ) {}
    #[Route('/', name: 'app_main')]
    public function index(): Response
    {
        $collections = $this->cr->findBy([], ['updated' => 'ASC'], 5);
        // dd($collections);
        return $this->render('main/index.html.twig', [
            'collections' => $collections
        ]);
    }
}
