<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Category;
use App\Form\CategoryType;
use App\Form\CollectionCreateType;
use App\Serviсes\FormSubmit;
use Doctrine\ORM\EntityManagerInterface;

class CollectionCreateController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $em,
        private FormSubmit $formSubmit
    ) {}

    #[Route('/collection/create', name: 'app_collection_create')]
    public function index(Request $request): Response
    {
        if(!$this->isGranted('ROLE_USER')) {
            $this->addFlash('danger', "Sign in to create a collection");
            return $this->redirectToRoute('app_collections');
        }

        $category = new Category();

        $form = $this->createForm(CollectionCreateType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->formSubmit->submitCategory($category);
            $categoryName = $category->getName();
            $this->addFlash('success', "Collection $categoryName created successfully");
            return $this->redirect('/collections');
        }

        return $this->render('collection_create/index.html.twig', [
            'form' => $form,
        ]);
    }
}
