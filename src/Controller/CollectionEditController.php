<?php

namespace App\Controller;

use App\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class CollectionEditController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $em,
        private CategoryRepository $categoryRepository
    ) {}

    #[Route('/collection/edit/{id}', name: 'app_category_edit', methods: ['GET'])]
    public function index(int $id): Response
    {
        $category = $this->categoryRepository->find($id);
        return $this->render('collection_edit/index.html.twig', [
            'action' => 'Edit collection',
            'category' => $category,
        ]);
    }

    #[Route('/collection/edit/{id}', name: 'app_category_edit_save', methods: ['POST'])]
    public function update(int $id, ?Request $request)
    {
        $category = $this->categoryRepository->find($id);
        $newCategoryName = $request->get('collectionnewname');
        $category->setName($newCategoryName);
        $this->em->flush();

        $this->addFlash('success', "Collection $newCategoryName updated successfully");

        return $this->render('collection_edit/index.html.twig', [
            'action' => 'Edit collection',
            'category' => $category,
        ]);
    }

    
    #[Route('/collection/delete/{id}', name: 'app_category_remove', methods: ['GET'])]
    public function remove(int $id)
    {

        $category = $this->categoryRepository->findOneBy(['id' => $id]);
        $categoryName = $category->getName();
        $this->em->remove($category);
        $this->em->flush();
        $this->addFlash('success', "Collection $categoryName deleted successfully");

        return $this->redirect('/collections');
    }
}
