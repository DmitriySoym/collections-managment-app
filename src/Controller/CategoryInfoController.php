<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\CategoryRepository;
use App\Repository\CustomAttributeRepository;

#[Route('/{_locale<%app.supported_locales%>}')]
class CategoryInfoController extends AbstractController
{
        public function __construct(
        private CategoryRepository $cr,
        private CustomAttributeRepository $customAttribites
    ) {}

    #[Route('/collection/info/{id}', name: 'app_category_info')]
    public function index(int $id): Response
    {
        $category = $this->cr->find($id);
        $customAttributes = $this->customAttribites->findBy(['category' => $id]);
        
        return $this->render('category_info/index.html.twig', [
            'category' => $category,
            'customAttributes' => $customAttributes
        ]);
    }
}
