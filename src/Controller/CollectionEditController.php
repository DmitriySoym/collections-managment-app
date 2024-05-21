<?php

namespace App\Controller;

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
        private CategoryRepository $cr
    ) {}

    #[Route('/collection/edit/{id}', name: 'app_category_edit', methods: ['GET'])]
    public function index(int $id): Response
    {
        $category = $this->cr->find($id);
        return $this->render('collection_edit/index.html.twig', [
            'action' => 'Edit collection',
            'category' => $category,
        ]);
    }

    #[Route('/collection/edit/{id}', name: 'app_category_edit_save', methods: ['POST'])]
    public function update(int $id, ?Request $request)
    {
        if(!$this->isGranted('ROLE_ADMIN') && !$this->cr->checkUserAccess($this->getUser(), $id)) {
            $this->addFlash('danger', "Only admins and collection owner can edit collections");
            return $this->redirectToRoute('app_category_edit', ['id' => $id]);
        }

        $oldCategoryName  = $this->cr->findOneBy(['id' => $id])->getName();
        $this->cr->editCategoryName($id, $request, $this->em);
        $this->addFlash('success', "Collection $oldCategoryName updated successfully");

        return $this->render('collection_edit/index.html.twig', [
            'category' => $this->cr->findOneBy(['id' => $id]),
        ]);
    }

    
    #[Route('/collection/delete/{id}', name: 'app_category_remove', methods: ['GET'])]
    public function remove(int $id)
    {

        if(!$this->isGranted('ROLE_ADMIN') && !$this->cr->checkUserAccess($this->getUser(), $id)) {
            $this->addFlash('danger', "Only admins and collection owner can delete collections");
            
            return $this->redirectToRoute('app_category_edit', ['id' => $id]);
        }

        $deletedCategoryName  = $this->cr->findOneBy(['id' => $id])->getName();
        $this->cr->deleteCategory($id);

        $this->addFlash('success', "Collection $deletedCategoryName deleted successfully");

        return $this->redirect('/collections');
    }
}
