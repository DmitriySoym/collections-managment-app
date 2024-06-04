<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\CategoryRepository;
use App\Repository\CustomAttributeRepository;
use App\Repository\CategoryCollectionRepository;
use Symfony\Component\HttpFoundation\Request;

#[Route('/{_locale<%app.supported_locales%>}')]
class CategoryInfoController extends AbstractController
{
        public function __construct(
        private CategoryRepository $cr,
        private CustomAttributeRepository $customAttribites,
        private CategoryCollectionRepository $ccr
    ) {}

    #[Route('/collection/info/{id}', name: 'app_category_info')]
    public function index(int $id, Request $request=null): Response
    {
        $searchfor = $request->query->get('searchfor') ?? '';

        $category = $this->cr->find($id);
        $collectionItems = $this->ccr->collectionItemsAmount($searchfor, $id);

        return $this->render('category_info/index.html.twig', [
            'category' => $category,
            'collectionItems' => $collectionItems,
            'searchfor' => $searchfor,
        ]);
    }
}
