<?php

namespace App\Controller;
use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;

class CollectionsController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $em,
        ) {}

    #[Route('/collections', name: 'app_collections')]
    public function index(CategoryRepository $categoryRepository): Response
    {
        if($this->getUser()) {
            $username = $this->getUser()->getUserIdentifier();
        } else {
            $username = 'Guest';
        }
        $categories = $categoryRepository->findAll();
        // dd($username);
        return $this->render('collections/index.html.twig', [
            'username' => $username,
            'categories' => $categories
        ]);
    }

    #[Route('/collections/create', name: 'app_collections_create', methods: [Request::METHOD_GET, Request::METHOD_POST])]
    public function create(Request $request): Response
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

        return $this->render('collections/create.html.twig', [
            'action' => 'Create category',
            'form' => $form,
        ]);
    }

    #[Route('/collections/edit/{id}', name: 'app_collections_edit')]
    public function edit(Request $request, int $id): Response
    {
        return $this->render('collections/edit.html.twig', [
            'action' => 'Edit category',
        ]);
    }
}
