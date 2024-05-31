<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/{_locale<%app.supported_locales%>}')]
class UserManagmentController extends AbstractController
{
    public function __construct(
        private TranslatorInterface $translator
    ) {}

    #[Route('/users/managment', name: 'app_user_managment')]
    public function index(UserRepository $ur, Request $request): Response
    {
        $messageAccsess = $this->translator->trans('mainPage.OnlyAdminsAccess');

        if(!$this->isGranted('ROLE_ADMIN')) {
            $this->addFlash('danger', $messageAccsess);
            return $this->redirectToRoute('app_main');
        }

        $searchUser = $request->query->get('searchUser') ?? '';

        $users = $ur->getAllUsers($searchUser);


        return $this->render('user_managment/index.html.twig', [
            'users' => $users,
            'searchUser' => $searchUser
        ]);
    }

    #[Route('/users/managment/update', name: 'app_user_managment_update', methods: ['POST'])]
    public function updateUsersStatus(Request $request, EntityManagerInterface $em, UserRepository $ur): JsonResponse
    {

        $data = json_decode($request->getContent(), true);
        $userIds = $data['ids'];
        $status = $data['status'];
        $users = $em->getRepository(User::class)->findBy(['id' => $userIds]);
        foreach ($users as $user) {
            $ur->changeStatus($status, $user);
        }
        $em->flush();

        return new JsonResponse('ok');
    }
}
