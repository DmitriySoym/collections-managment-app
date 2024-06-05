<?php

namespace App\Controller;

use App\Entity\Comments;
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
use App\Repository\CommentsRepository;
use App\Repository\LikeRepository;
use App\Entity\Like;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\Category;
use App\Form\CommentType;
use App\Serviсes\CustomAttributeService;


class CollectionItemController extends AbstractController
{
        public function __construct(
        private EntityManagerInterface $em,
        private CategoryRepository $cr,
        private CommentsRepository $comments,
        private CategoryCollectionRepository $ccr,
        private FormSubmit $formSubmit,
        private TranslatorInterface $translator,
        private CustomAttributeService $customAttributeService,
        private LikeRepository $lr
    ) {}

    #[Route('/{_locale<%app.supported_locales%>}/collection/{id}/item/{itemId}', name: 'app_collection_item', methods: ['GET', 'POST'])]
    public function index(int $id, int $itemId, Request $request): Response
    {
        $category = $this->cr->find($id);
        $itemCollection = $this->ccr->find($itemId);
        $customAttributes = $itemCollection->getItemAttributeStringFields();
        $likeStatus = null;
        $likesCount = null;
        if($this->getUser()) {
            $likeStatus = $this->lr->findLike($this->getUser(), $itemCollection);
            $likesCount = $this->lr->findBy(['item' => $itemCollection->getId(), 'status' => true]);
        }
        $comments = $this->comments->findBy(['item' => $itemCollection->getId()]);
        $comment = new Comments();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($request->isMethod('POST') && $form->isValid() && $form->isSubmitted() ) {
            $this->formSubmit->addComment($form, $itemCollection);
            return $this->redirectToRoute('app_collection_item', ['id' => $id, 'itemId' => $itemId]);
        }

        return $this->render('collection_item/index.html.twig', [
            'itemCollection' => $itemCollection,
            'category' => $category,
            'customAttributes' => $customAttributes,
            'comments' => $comments,
            'form' => $form,
            'likeStatus' => $likeStatus,
            'likesCount' => $likesCount,
        ]);
    }

    #[Route('/{_locale<%app.supported_locales%>}/collection/{id}/createitem', name: 'app_collection_item_create', methods: [Request::METHOD_GET, Request::METHOD_POST])]
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

        $itemCollection = $this->customAttributeService->setItemCustomAttributes($collection, $itemId = null);

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

    #[Route('/{_locale<%app.supported_locales%>}/collection/{id}/edititem/{itemId}', name: 'app_collection_edit_item', methods: ['GET','POST'])]
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

    #[Route('/{_locale<%app.supported_locales%>}/collection/{id}/deleteitem/{itemId}', name: 'app_collection_item_delete', methods: ['GET'])]
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

    #[Route('/api/like/item/{itemId}', name: 'app_item_like', methods: [Request::METHOD_POST])]
    public function like(int $itemId): JsonResponse
    {
        $user = $this->getUser();
        $item = $this->ccr->find($itemId);
        $likeStatus = $this->lr->findLike($user, $item);

        if(!$likeStatus) {
            $this->formSubmit->addNewLike($item);

            return $this->json([
                'liked' => true
            ]);
        }

        if($likeStatus->isStatus() == false) {
            $like = $this->lr->findLike($user, $item);
            $like->setStatus(true);
            $this->em->flush();

            return $this->json([
                'liked' => true,
            ]);
        } else {
            $like = $this->lr->findLike($user, $item);
            $like->setStatus(false);
            $this->em->flush();

            return $this->json([
                'liked' => false,
            ]);
        }

        return new JsonResponse('ok');
    }
}
