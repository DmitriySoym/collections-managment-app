<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\CategoryRepository;

#[Route('/{_locale<%app.supported_locales%>}')]
class UserAccountController extends AbstractController
{
    public function __construct(
        private TranslatorInterface $translator,
        private CategoryRepository $cr
    ) {}

    #[Route('/user/{userName}/{!page}', name: 'app_user_account')]
    public function index(Request $request, string $userName, int $page = 1): Response
    {
        $user = $this->getUser();
        $limit = 6;


        if($this->getUser() === null || !$this->isGranted('ROLE_ADMIN') && $this->getUser()->getUserIdentifier() !== $userName) {
            return $this->redirectToRoute('app_main');
        }

        $searchfor = $request->query->get('searchfor') ?? '';
        $userId = $this->getUser()->getId();

        $collections = $this->cr->usersCollection($user->getId(), $searchfor, $page, $limit);
        $categoryAmount = ceil(count($this->cr->usersCollectionAmount($userId ,$searchfor)) / $limit);

        return $this->render('user_account/index.html.twig', [
            'searchfor' => $searchfor,
            'user' => $user,
            'collections' => $collections,
            'categoryAmount' => $categoryAmount
        ]);
    }
}
