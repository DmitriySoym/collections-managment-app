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

class UserManagmentController extends AbstractController
{
    #[Route('/user/managment', name: 'app_user_managment')]
    public function index(UserRepository $ur): Response
    {
        if(!$this->isGranted('ROLE_ADMIN')) {
            $this->addFlash('danger', "Only admins have access to this page");
            return $this->redirectToRoute('app_main');
        }

        $users = $ur->findAll();

        return $this->render('user_managment/index.html.twig', [
            'users' => $users,
        ]);
    }

    #[Route('/user/managment/update', name: 'app_user_managment_update', methods: ['POST'])]
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
