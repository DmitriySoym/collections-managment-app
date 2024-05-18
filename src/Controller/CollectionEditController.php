<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;

class CollectionEditController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $em,
    ) {}

    #[Route('/collection/edit/{id}', name: 'app_category_edit')]
    public function index(CategoryRepository $categoryRepository, int $id): Response
    {
        $category = $categoryRepository->find($id);
        return $this->render('collection_edit/index.html.twig', [
            'action' => 'Edit collection',
            'category' => $category
        ]);
    }

    #[Route('/collection/remove/{id}', name: 'app_category_remove')]
    public function remove(CategoryRepository $categoryRepository, int $id): Response
    {
        $category = $categoryRepository->find($id);
        $this->em->remove($category);
        $this->em->flush();
        return $this->redirectToRoute('app_category_list');
    }
}
