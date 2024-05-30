<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\CategoryRepository;
use App\Entity\User;

#[Route('/{_locale<%app.supported_locales%>}')]
class UserAccountController extends AbstractController
{
    public function __construct(
        private TranslatorInterface $translator,
        private CategoryRepository $cr
    ) {}

    #[Route('/user/{userName}/{page}', name: 'app_user_account')]
    public function index(Request $request, string $userName, int $page = 1): Response
    {
        $user = $this->getUser();
        $limit = 6;


        $messageAccsess = $this->translator->trans('collection.canAddCollectionItems');
        if(!$this->isGranted('ROLE_ADMIN') && $this->getUser()->getUserIdentifier() !== $userName) {
            $this->addFlash('danger', $messageAccsess);
            return $this->redirectToRoute('app_main');
        }

        $searchfor = $request->query->get('searchfor') ?? '';

        // $collections = $this->cr->findBy(['author' => $user->getId()], ['name' => 'ASC'], 6, 0, $searchfor);
        $collections = $this->cr->usersCollection($user->getId(), $searchfor, $page, $limit);
        $categoryAmount = ceil(count($collections) / $limit);

        return $this->render('user_account/index.html.twig', [
            'searchfor' => $searchfor,
            'user' => $user,
            'collections' => $collections,
            'categoryAmount' => $categoryAmount
        ]);
    }
}
