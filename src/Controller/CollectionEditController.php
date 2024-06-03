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
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/{_locale<%app.supported_locales%>}')]
class CollectionEditController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $em,
        private CategoryRepository $cr,
        private FormSubmit $formSubmit,
        private TranslatorInterface $translator
    ) {}

    #[Route('/collection/edit/{id}', name: 'app_category_edit', methods: ['GET', 'POST'])]
    public function index(int $id, Request $request, Category $category): Response
    {
        $messageAccess = $this->translator->trans('createCollection.canEditCollections');

        if(!$this->isGranted('ROLE_ADMIN') && !$this->cr->checkUserAccess($this->getUser(), $id)) {
            $this->addFlash('danger', $messageAccess);
            
            return $this->redirectToRoute('app_category_info', ['id' => $id]);
        }

        $messageSuccess = $this->translator->trans('createCollection.collectionUpdatedSuccessfully');

        $form = $this->createForm(CollectionCreateType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->formSubmit->submitCategory($category);
            $this->addFlash('success', $messageSuccess);
            return $this->redirectToRoute('app_category_info', ['id' => $id]);
        }

        return $this->render('collection_edit/index.html.twig', [
            'category' => $category,
            'form' => $form,
        ]);
    }

    #[Route('/collection/delete/{id}', name: 'app_category_remove', methods: ['GET'])]
    public function remove(int $id)
    {

        $this->cr->deleteCategory($id);

        $messageSuccess = $this->translator->trans('createCollection.collectionDeleted');

        $this->addFlash('success', $messageSuccess);

        return $this->redirectToRoute('app_collections', ['page' => 1]);
    }
}
