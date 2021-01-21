<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WorkoutController extends AbstractController
{
    /**
     * @Route("/workout", name="workout")
     */
    public function WorkoutList(): Response
    {
        //"TODO.."

        // Etape 1 : recuperer les workout présents en BDD

        // Etape 2 : retourner les données en JSON
    }
}
