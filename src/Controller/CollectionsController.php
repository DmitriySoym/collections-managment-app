<?php

namespace App\Controller;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\Persistence\ManagerRegistry;

class CollectionsController extends AbstractController
{
    #[Route('/collections', name: 'app_collections')]
    public function index(): Response
    {
        if($this->getUser()) {
            $username = $this->getUser()->getUsername();
        } else {
            $username = 'Guest';
        }
        // $username = $this->getUser()->getUsername();
        // dd($username);
        return $this->render('collections/index.html.twig', [
            'username' => $username,
        ]);
    }
}
