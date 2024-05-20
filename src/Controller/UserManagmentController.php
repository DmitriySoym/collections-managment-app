<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class UserManagmentController extends AbstractController
{
    #[Route('/user/managment', name: 'app_user_managment')]
    public function index(UserRepository $ur): Response
    {
        if(!$this->isGranted('ROLE_ADMIN')) {
            $this->addFlash('danger', "Only admin have access to this page");
            return $this->redirectToRoute('app_main');
        }

        $users = $ur->findAll();

        return $this->render('user_managment/index.html.twig', [
            'users' => $users,
        ]);
    }
}
