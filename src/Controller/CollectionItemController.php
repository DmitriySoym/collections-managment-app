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

class CollectionItemController extends AbstractController
{
        public function __construct(
        private EntityManagerInterface $em,
        private CategoryRepository $cr
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
            return $this->redirectToRoute('app_category_edit', ['id' => $id]);
        }

        $user = $this->getUser();
        
        $itemCollection = new CategoryCollection();
        $form = $this->createForm(CategoryItemType::class, $itemCollection);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            //saving data
            // $itemCollection->setUserId($user);
            $itemCollection->setCreated(new \DateTime());
            $itemCollection->setUpdated(new \DateTime());
            $itemCollection->setCategotyId($this->cr->find($id));
            $this->em->persist($itemCollection);
            $this->em->flush();

            $itemCollectionName = $itemCollection->getName();

            $this->addFlash('success', "Collection $itemCollectionName created successfully");

            return $this->redirectToRoute('app_category_edit', [
                'id' => $id,
            ]);
        }

        return $this->render('collection_item/form.html.twig', [
            // 'form' => $form->createView()
            'form' => $form,
            'id' => $id
        ]);
    }
}
