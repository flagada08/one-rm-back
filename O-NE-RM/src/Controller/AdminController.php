<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{
    /**
     * @Route("api/back/admin", name="admin")
     */
    public function userList(UserRepository $userRepository): Response
    {
        $user = $userRepository->findAll();
        
        return $this->json($user, Response::HTTP_OK, [], ['groups' => 'infos']);
    }
}

