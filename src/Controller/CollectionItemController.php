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
use Symfony\Contracts\Translation\TranslatorInterface;
use App\Repository\CategoryCollectionRepository;
use App\Entity\Category;
use App\Entity\CustomAttribute;
use App\Entity\ItemAttributeBooleanField;
use App\Entity\ItemAttributeDateField;
use App\Entity\ItemAttributeStringField;
use App\Enum\CustomAttributeType;

#[Route('/{_locale<%app.supported_locales%>}')]
class CollectionItemController extends AbstractController
{
        public function __construct(
        private EntityManagerInterface $em,
        private CategoryRepository $cr,
        private CategoryCollectionRepository $ccr,
        private FormSubmit $formSubmit,
        private TranslatorInterface $translator
    ) {}

    #[Route('/collection/{id}/item/{itemId}', name: 'app_collection_item')]
    public function index(int $id, int $itemId): Response
    {
        // $itemId = $this->ccr->find($itemId);

        $category = $this->cr->find($id);
        $itemCollection = $this->ccr->find($this->ccr->find($itemId));
        $customAttributes = $itemCollection->getItemAttributeStringFields();

        return $this->render('collection_item/index.html.twig', [
            'controller_name' => 'ColectionItemController',
            'itemCollection' => $itemCollection,
            'category' => $category,
            'customAttributes' => $customAttributes
        ]);
    }

    #[Route('/collection/{id}/createitem', name: 'app_collection_item_create', methods: [Request::METHOD_GET, Request::METHOD_POST])]
    public function create(
        Request $request, 
        Category $collection, 
        int $id): Response
    {

        $messageAccsess = $this->translator->trans('collection.canAddCollectionItems');

        if(!$this->isGranted('ROLE_ADMIN') && !$this->cr->checkUserAccess($this->getUser(), $id)) {
            $this->addFlash('danger', $messageAccsess);
            return $this->redirectToRoute('app_category_info', ['id' => $id]);
        }

        $itemCollection = $this->setItemCustomAttributes($collection, $itemId = null);

        $form = $this->createForm(CategoryItemType::class, $itemCollection);
        $form->handleRequest($request);
        $category = $this->cr->find($id);

        if($form->isSubmitted() && $form->isValid()) {
            $this->formSubmit->submitCategoryItem($itemCollection, $id);

            return $this->redirectToRoute('app_category_info', [
                'category' => $category,
                'id' => $id
            ]);
        }

        return $this->render('collection_item/form.html.twig', [
            'form' => $form,
            'id' => $id,
            'category' => $category
        ]);
    }

    #[Route('/collection/{id}/edititem/{itemId}', name: 'app_collection_edit_item', methods: ['GET','POST'])]
    public function update(
        Category $collection, 
        Request $request, 
        int $id,
        int $itemId): Response
    {

        $messageAccsess = $this->translator->trans('collection.canAddCollectionItems');

        if(!$this->isGranted('ROLE_ADMIN') && !$this->cr->checkUserAccess($this->getUser(), $id)) {
            $this->addFlash('danger', $messageAccsess);
            return $this->redirectToRoute('app_category_info', ['id' => $id]);
        }

        $itemCollection = $this->ccr->find($itemId);
        $form = $this->createForm(CategoryItemType::class, $itemCollection);
        $form->handleRequest($request);
        $category = $this->cr->find($id);

        if($form->isSubmitted() && $form->isValid()) {

            $this->formSubmit->submitCategoryItem($itemCollection, $id);
            return $this->redirectToRoute('app_collection_item', [
                'category' => $category,
                'id' => $id,
                'itemId' => $itemId
            ]);
        }

        return $this->render('collection_item/form_update.html.twig', [
            'form' => $form,
            'id' => $id,
            'category' => $category
        ]);
    }

    #[Route('/collection/{id}/deleteitem/{itemId}', name: 'app_collection_item_delete', methods: ['GET'])]
    public function delete(int $id, int $itemId): Response
    {
        $messageAccsess = $this->translator->trans('createCollection.canEditCollections');
        if(!$this->isGranted('ROLE_ADMIN') && !$this->cr->checkUserAccess($this->getUser(), $id)) {
            $this->addFlash('danger', $messageAccsess);
            return $this->redirectToRoute('app_category_info', ['id' => $id]);
        }

        $itemCollection = $this->ccr->find($itemId);
        $category = $this->cr->find($id);

        $this->em->remove($itemCollection);
        $this->em->flush();
        return $this->redirectToRoute('app_category_info', [
            'category' => $category,
            'id' => $id,
        ]);
    }

    private function setItemCustomAttributes(Category $itemsCollection, int|null $itemId): CategoryCollection {
        $item = $itemId ? $this->ccr->find($itemId) : new CategoryCollection();
        // $item = new CategoryCollection();
        $customAttributes = $itemsCollection->getCustomAttributes()->getValues();
        foreach ($customAttributes as $customAttribute) {
            switch ($customAttribute->getType())
            {
                case CustomAttributeType::String:
                    $item = $this->setStringAttributes($item, $customAttribute);
                    break;
                // case CustomAttributeType::Integer:
                //     $item = $this->setIntegerAttributes($item, $customAttributeValue);
                //     break;
                // case CustomAttributeType::Text:
                //     $item = $this->setTextAttributes($item, $customAttributeValue);
                //     break;
                case CustomAttributeType::Boolean:
                    $item = $this->setBooleanAttributes($item, $customAttribute);
                    break;
                case CustomAttributeType::Date:
                    $item = $this->setDateAttributes($item, $customAttribute);
                    break;
            }
        }
        return $item;
    }

    // private function setIntegerAttributes(CategoryCollection $item, CustomAttribute $customAttributeValue): CategoryCollection{
    //     $itemAttributeInteger = new ItemAttributeIntegerField();
    //     $itemAttributeInteger->setCustomItemAttribute($customAttributeValue);
    //     $item->addItemAttributeIntegerField($itemAttributeInteger);
    //     $this->entityManager->persist($itemAttributeInteger);

    //     return $item;
    // }

    private function setStringAttributes(CategoryCollection $item, CustomAttribute $customAttributeValue): CategoryCollection{
        $itemAttributeString = new ItemAttributeStringField();
        $itemAttributeString->setCustomItemAttribute($customAttributeValue);
        $item->addItemAttributeStringField($itemAttributeString);
        $this->em->persist($itemAttributeString);

        return $item;
    }

    private function setBooleanAttributes(CategoryCollection $item, CustomAttribute $customAttributeValue): CategoryCollection{
        $itemAttributeBoolean = new ItemAttributeBooleanField();
        $itemAttributeBoolean->setCustomItemAttribute($customAttributeValue);
        $item->addItemAttributeBooleanField($itemAttributeBoolean);
        $this->em->persist($itemAttributeBoolean);

        return $item;
    }

    private function setDateAttributes(CategoryCollection $item, CustomAttribute $customAttributeValue): CategoryCollection{
        $itemAttributeDate = new ItemAttributeDateField();
        $itemAttributeDate->setCustomItemAttribute($customAttributeValue);
        $itemAttributeDate->setValue(new \DateTime());
        $item->addItemAttributeDateField($itemAttributeDate);
        $this->em->persist($itemAttributeDate);

        return $item;
    }
}
