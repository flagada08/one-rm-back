<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Exercise;
use App\Repository\UserRepository;
use App\Repository\ExerciseRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\FitnessRoomRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class UserController extends AbstractController
{


    /**
     * @Route("/user/{id}/profil", name="profil")
     */
    public function profil(User $user, UserRepository $userRepository): Response
    {
        $userData = $userRepository->find($user);

        return $this->json($userData,  Response::HTTP_OK, [], ['groups' => 'infos']);
    }

    /**
     * @Route("/user/{id}/edit", name="user", methods={"PUT","PATCH"})
     */
    public function edit(User $user, EntityManagerInterface $em, SerializerInterface $serializer, Request $request, ValidatorInterface $validator): Response
    {
        $jsonContent = $request->getContent();

        $object = $serializer->deserialize($jsonContent, User::class, 'json', [AbstractNormalizer::OBJECT_TO_POPULATE => $user] );

        $error = $validator->validate($user);

        if (count($error) > 0) {

            return $this->json('erreur mon amis', Response::HTTP_UNPROCESSABLE_ENTITY);

        }

        $em->flush();

        return $this->json(['message' => 'User modifié.'], Response::HTTP_OK);
    }

    /**
     * @Route("/user/{id}/performances", name="performances")
     */
    public function performance(User $user): Response
    {
        return $this->json('coucou');
    }

    /**
     * @Route("/user/{id}/workout/", name="test")
     */
    public function workout(User $user, Exercise $exercise, ExerciseRepository $exerciseRepository){

        $currentExercise = $exerciseRepository->find($exercise);

        return $this->json($currentExercise);
    }    



    /**
     * @Route("/user/{id}/workout/newPerf", name="newPerformance", methods={"POST"})
     */
    public function newPerf(): Response
    {
        //TODO
    }

     /**
     * @Route("/user/{id}/workout/goal", name="goal", methods={"POST","PUT","PATCH"})
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
        return $this->json(['message' => 'coucou laurie'], Response::HTTP_CREATED);

    }

    // /**
    //  * @Route("/test", name="test", methods={"POST","GET"})
    //  */
    // public function test(FitnessRoomRepository $fitnessRoomRepository, SerializerInterface $serializer) {

    //     $test = $fitnessRoomRepository->find(2);
    

    //     return $this->json($test, Response::HTTP_OK, [], ['groups' => 'test']);
    // }

}
