<?php

namespace App\Controller;

use App\Entity\CategoryCollection;
use App\Form\CategoryItemType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\CategoryRepository;
use App\Serviсes\FormSubmit;

class CollectionItemController extends AbstractController
{
        public function __construct(
        private EntityManagerInterface $em,
        private CategoryRepository $cr,
        private FormSubmit $formSubmit
    ) {}

    #[Route('/collection/{id}/item/{{itemId}}', name: 'app_collection_item')]
    public function index(int $id, int $itemId): Response
    {
        return $this->render('collection_item/index.html.twig', [
            'controller_name' => 'ColectionItemController',
        ]);
    }

    #[Route('/collection/{id}/item/create', name: 'app_collection_item_create', methods: [Request::METHOD_GET, Request::METHOD_POST])]
    public function create(Request $request, int $id): Response
    {

        if(!$this->isGranted('ROLE_ADMIN') && !$this->cr->checkUserAccess($this->getUser(), $id)) {
            $this->addFlash('danger', "Only admins and collection owner can add collection items");
            return $this->redirectToRoute('app_category_info', ['id' => $id]);
        }

        $itemCollection = new CategoryCollection();
        $form = $this->createForm(CategoryItemType::class, $itemCollection);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $this->formSubmit->submitCategoryItem($itemCollection, $id);

            $category = $this->cr->find($id);
            return $this->redirectToRoute('app_category_info', [
                'category' => $category,
                'id' => $id
            ]);
        }

        return $this->render('collection_item/form.html.twig', [
            'form' => $form,
            'id' => $id
        ]);
    }
}
