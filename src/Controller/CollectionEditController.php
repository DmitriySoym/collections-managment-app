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

    #[Route('/collection/edit/{id}', name: 'app_category_edit')]
    public function index(int $id): Response
    {
        $category = $this->categoryRepository->find($id);
        return $this->render('collection_edit/index.html.twig', [
            'action' => 'Edit collection',
            'category' => $category,
        ]);
    }

    #[Route('/collection/remove/{id}', name: 'app_category_remove')]
    public function remove(int $id): Response
    {
        $category = $this->categoryRepository->find($id);
        $categoryName = $category->getName();
        // $this->em->remove($category);
        // $this->em->flush();
        $this->addFlash('success', "Collection $categoryName deleted successfully");

        return $this->redirectToRoute('app_collections');
    }

    #[Route('/collection/update/{id}', name: 'app_category_edit_save', methods: ['POST'])]
    // public function update(CategoryRepository $categoryRepository, int $id): void
    // {
    //     $category = $categoryRepository->find($id);
    //     // $newCategoryName = $category->getName();
    //     $newCategoryName = 'New name';
    //     $category->setName($newCategoryName);
    //     $this->em->persist($category);
    //     $this->em->flush();

    // }
    public function update(int $id, Request $request)
    {
        $category = $this->categoryRepository->find($id);
        $category->setName('New collection name!');
        $this->em->flush();

        // $category->setName('New collection name!');
        // $this->em->persist($category);
        // $this->em->flush();

        // return $this->redirectToRoute('app_category_edit', [
        //     'action' => 'Edit collection',
        //     'category' => $category
        // ]);
    }
}
