<?php

namespace App\Controller;
use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;

class CollectionsController extends AbstractController
{
    #[Route('/collections/{page}', name: 'app_collections')]
    public function index(CategoryRepository $categoryRepository, int $page = 1, int $limit = 15, ?Request $request=null): Response
    {
        $this->getUser() ? $username = $this->getUser()->getUserIdentifier() : $username = 'Guest';
        $searchfor = $request->query->get('searchfor') ?? '';
        $categories = $categoryRepository->paginatedCategories($page, $limit, $searchfor);
        $categoryAmount = ceil($categoryRepository->count() / $limit);
        $test = count($categoryRepository->findAll());

        return $this->render('collections/index.html.twig', [
            'username' => $username,
            'categories' => $categories,
            'categoryAmount' => $categoryAmount,
            'searchfor' => $searchfor,
            'limit' => $limit,
            'test' => $test
        ]);
    }
}
