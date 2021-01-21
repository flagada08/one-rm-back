<?php

namespace App\Controller;

use App\Entity\Exercise;
use App\Repository\ExerciseRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\SerializerInterface;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function Home(UserRepository $user, SerializerInterface $serializer): Response
    {

        $list = $user->findAll();
        
        return $this->json($list, Response::HTTP_OK, [], ['groups' => 'test']);
    }
}
