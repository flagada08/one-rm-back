<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{


    /**
     * @Route("/user/profil", name="profil")
     */
    public function profil(): Response
    {
        return $this->render('user/index.html.twig', ['titi' => 'toto']);
    }


    /**
     * @Route("/user/edit", name="user", methods={"PUT","PATCH"})
     */
    public function edit(): Response
    {
        return $this->render('user/index.html.twig');
    }

    /**
     * @Route("/user/performances", name="performances")
     */
    public function performance(): Response
    {
        return $this->render('user/index.html.twig');
    }

    /**
     * @Route("/user/workout/{id}", name="workout")
     */
    public function workout(): Response
    {
        return $this->render('user/index.html.twig');
    }

    /**
     * @Route("/user/workout/{id}/newPerf", name="newPerformance", methods={"POST"})
     */
    public function newPerf(): Response
    {
        return $this->render('user/index.html.twig');
    }

     /**
     * @Route("/user/workout/{id}/goal", name="goal", methods={"POST","PUT","PATCH"})
     */
    public function goal(): Response
    {
        return $this->render('user/index.html.twig');
    }

}
