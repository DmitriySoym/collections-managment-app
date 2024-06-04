<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Request;

#[Route('/{_locale<%app.supported_locales%>}')]
class MainController extends AbstractController
{

        public function __construct(
        private CategoryRepository $cr,
    ) {}
    #[Route('/', name: 'app_main')]
    public function index(?Request $request=null): Response
    {
        $searchfor = $request->query->get('searchfor') ?? '';
        $collections = $this->cr->findBy([], ['updated' => 'ASC'], 5);

        return $this->render('main/index.html.twig', [
            'collections' => $collections,
            'searchfor' => $searchfor,
        ]);
    }
}
