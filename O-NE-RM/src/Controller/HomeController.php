<?php

namespace App\Controller;

use App\Entity\Exercise;
use App\Repository\ExerciseRepository;
use App\Repository\FitnessRoomRepository;
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
    public function Home(ExerciseRepository $exercise): Response
    {

        $list = $exercise->findAll();
        
        return $this->json($list, Response::HTTP_OK, [], ['groups' => 'workout_get']);
    }

    /**
     * Méthode renvoyant la liste des salles de sport pour le select du formulaire d'inscription
     *
     * @Route("/getFitnessRoomList", name="getFitnessRoomList")
     */
    public function fitnessRoomList(FitnessRoomRepository $fitnessRoomRepository) {

        $fitnessRoomList = $fitnessRoomRepository->findAll();

        return $this->json($fitnessRoomList, Response::HTTP_OK, [], ['groups' => 'fitnessRoom_get']);

    }


}
