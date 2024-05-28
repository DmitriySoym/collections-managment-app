<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Category;
use App\Form\CollectionCreateType;
use App\Serviсes\FormSubmit;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/{_locale<%app.supported_locales%>}')]
class CollectionCreateController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $em,
        private FormSubmit $formSubmit,
        private TranslatorInterface $translator
    ) {}

    #[Route('/collection/create', name: 'app_collection_create')]
    public function index(Request $request): Response
    {
        $messageSignIn = $this->translator->trans('collection.signInToCreate');

        if(!$this->isGranted('ROLE_USER')) {
            $this->addFlash('danger', $messageSignIn);
            return $this->redirectToRoute('app_collections');
        }

        $category = new Category();

        $form = $this->createForm(CollectionCreateType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->formSubmit->submitCategory($category);
            $categoryName = $category->getName();
            $messageCreated = $this->translator->trans('createCollection.collectionNameCreated', ['%name%' => $categoryName]);
            $this->addFlash('success', $messageCreated);
            return $this->redirectToRoute('app_collections');
        }

        return $this->render('collection_create/index.html.twig', [
            'form' => $form,
        ]);
    }
}
