<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\CategoryCollectionRepository;
use App\Repository\LikeRepository;
use App\Repository\UserRepository;
use App\Repository\CategoryRepository;

#[Route('/{_locale<%app.supported_locales%>}')]
class LikedItemsController extends AbstractController
{
    public function __construct(
        private CategoryCollectionRepository $ccr,
        private LikeRepository $lr,
        private CategoryRepository $cr,
    ) {}
    #[Route('/liked/items/{userName}', name: 'app_liked_items')]
    public function index(string $userName): Response
    {
        if($this->getUser()->getUserIdentifier() !== $userName) {
            return $this->redirectToRoute('app_main');
        }

        $user = $this->getUser();
        $likedItemsArray = $this->lr->findBy(['userLiked' => $user->getId(), 'status' => true]);
        $likedItems = [];
        foreach ($likedItemsArray as $item) {
            $itemId = $item->getItem()->getId();
            $item = $this->ccr->find($itemId);
            $category = $this->cr->find($item->getCategotyId());
            $likedItems[] = ['item' => $item, 'category' => $category];
        }

        return $this->render('liked_items/index.html.twig', [
            'likedItems' => $likedItems,
        ]);
    }
}
