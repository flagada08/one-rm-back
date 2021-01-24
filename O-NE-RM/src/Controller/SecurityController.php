<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    /**
     * Méthode qui va être appelée si le login JSON a fonctionné
     * 
     * @Route("/api/login", name="api_login", methods={"POST"})
     * 
     */
    public function apiLogin(Request $request)
    {
        // Le user est connecté, on le récupère
        $user = $this->getUser();

        // On retourne au front les infos nécessaires (selon le projet)
        // à adapter selon vos besoins
        return $this->json([
            'username' => $user->getUsername(),
            'roles' => $user->getRoles(),
        ]);
    }
}

