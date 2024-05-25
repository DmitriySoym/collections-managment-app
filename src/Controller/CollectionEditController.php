<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CollectionCreateType;
use App\Serviсes\FormSubmit;
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
        private CategoryRepository $cr,
        private FormSubmit $formSubmit
    ) {}

    #[Route('/collection/edit/{id}', name: 'app_category_edit', methods: ['GET', 'POST'])]
    public function index(int $id, Request $request, Category $category): Response
    {
        if(!$this->isGranted('ROLE_ADMIN') && !$this->cr->checkUserAccess($this->getUser(), $id)) {
            $this->addFlash('danger', "Only admins and collection owner can edit collections");
            
            return $this->redirectToRoute('app_category_info', ['id' => $id]);
        }

        $form = $this->createForm(CollectionCreateType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->formSubmit->submitCategory($category);
            $categoryName = $category->getName();
            $this->addFlash('success', "Collection $categoryName updated successfully");
            return $this->redirect('/collection/info/' . $id);
        }

        return $this->render('collection_edit/index.html.twig', [
            'category' => $category,
            'form' => $form,
        ]);
    }

    #[Route('/collection/delete/{id}', name: 'app_category_remove', methods: ['GET'])]
    public function remove(int $id)
    {

        $deletedCategoryName  = $this->cr->findOneBy(['id' => $id])->getName();
        $this->cr->deleteCategory($id);

        $this->addFlash('success', "Collection $deletedCategoryName deleted successfully");

        return $this->redirect('/collections');
    }
}
