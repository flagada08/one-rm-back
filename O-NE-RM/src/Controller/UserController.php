<?php

namespace App\Controller;

use App\Entity\FitnessRoom;
use App\Entity\User;
use App\Repository\FitnessRoomRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use ContainerKDoc2AZ\EntityManager_9a5be93;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserController extends AbstractController
{


    /**
     * @Route("/user/profil/{id}", name="profil")
     */
    public function profil(User $user, UserRepository $userRepository): Response
    {
        $userData = $userRepository->find($user);

        return $this->json($userData,  Response::HTTP_OK, [], ['groups' => 'infos']);
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

     /**
     * @Route("/register", name="register", methods={"POST","GET"})
     */
    public function create(EntityManagerInterface $entityManager, Request $request, SerializerInterface $serializer, ValidatorInterface $validator) 
    {

        $jsonContent = $request->getContent();


        $user = $serializer->deserialize($jsonContent, User::class, 'json' );
        
        
        dd($user);
        //  On valide l'entité désérialisée
        $errors = $validator->validate($user);

        // Si nombre d'erreur > 0 alors on renvoie une erreur
        if (count($errors) > 0) {
            // On retourne le tableau d'erreurs en Json au front avec un status code 422
            return $this->json('ca marche pas', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        
        // On persiste les données
        $entityManager->persist($user);

        // On flush pour enregistrer en BDD
        $entityManager->flush();

        // REST nous dit : status 201 + Location: movies/{id}
        return $this->redirectToRoute(
            'home',
            [
                'id' => $user->getId()
            ],
            Response::HTTP_CREATED
        );
    }

    // /**
    //  * @Route("/test", name="test", methods={"POST","GET"})
    //  */
    // public function test(FitnessRoomRepository $fitnessRoomRepository, SerializerInterface $serializer) {

    //     $test = $fitnessRoomRepository->find(2);
    

        

    //     return $this->json($test, Response::HTTP_OK, [], ['groups' => 'test']);
    // }

}
