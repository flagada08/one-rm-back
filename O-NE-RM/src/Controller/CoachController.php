<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\ProgressRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CoachController extends AbstractController
{
    /**
     * @Route("/api/coach", name="coach")
     */     
    public function userList(UserRepository $userRepository): Response
    {
        $user = $this->getUser();

        $fitnessRoom = $user->getFitnessroom();

        $userList = $userRepository->findBy(['fitnessRoom' => $fitnessRoom]);
        
        return $this->json($userList, Response::HTTP_OK, [], ['groups' => 'listUsersFitnesstRoom']);

    }


    /**
     * @Route("/api/coach/user/{id}/performances", name="userToCoach")
     */
    public function getUserPerformances(User $user = null, ProgressRepository $progressRepository) 
    {

        if ($user == null) {

            throw $this->createNotFoundException('utilisateur non trouvé.');
        }

        $userPerf = $progressRepository->findByExercise($user);
        
        return $this->json($userPerf, Response::HTTP_OK, [], ['groups' => 'progressUser']);
        

    }


    //TODO coder la possibilité de rentrer dans un exercice de l'utilisateur afin de poster un commentaire



    
}

