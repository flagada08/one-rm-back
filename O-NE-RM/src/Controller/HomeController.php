<?php

namespace App\Controller;

use App\Entity\Exercise;
use App\Repository\ExerciseRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function Home(ExerciseRepository $exercise): Response
    {

        $list = $exercise->findAll();

        

        return $this->json($list);
    }
}
