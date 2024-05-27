<?php

namespace App\Controller;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;

#[Route('/{_locale<%app.supported_locales%>}')]
class CollectionsController extends AbstractController
{
    #[Route('/collections/{page}', name: 'app_collections')]
    public function index(CategoryRepository $cr, int $page = 1, int $limit = 6, ?Request $request=null): Response
    {
        $this->getUser() ? $username = $this->getUser()->getUserIdentifier() : $username = 'Guest';
        $searchfor = $request->query->get('searchfor') ?? '';
        $categories = $cr->paginatedCategories($page, $limit, $searchfor);
        $categoryAmount = ceil($cr->count() / $limit);

        return $this->render('collections/index.html.twig', [
            'username' => $username,
            'categories' => $categories,
            'categoryAmount' => $categoryAmount,
            'searchfor' => $searchfor,
        ]);
    }
}
