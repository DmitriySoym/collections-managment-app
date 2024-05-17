<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Category;
use App\Form\CategoryType;
use Doctrine\ORM\EntityManagerInterface;

class CollectionCreateController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $em,
    ) {}

    #[Route('/collection/create', name: 'app_collection_create')]
    public function index(Request $request): Response
    {
        $category = new Category();

        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //saving data
            $this->em->persist($category);
            $this->em->flush();
            $categoryName = $category->getName();

            $this->addFlash('success', "Collection $categoryName created successfully");
        }
        return $this->render('collection_create/index.html.twig', [
            'action' => 'Create category',
            'form' => $form,
        ]);
    }
}
