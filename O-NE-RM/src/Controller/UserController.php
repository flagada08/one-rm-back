<?php

namespace App\Controller;


use App\Entity\User;
use App\Entity\Exercise;
use App\Entity\Progress;
use App\Repository\UserRepository;
use App\Repository\ExerciseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

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
        $performances = $user->getProgress();

        return $this->json($performances, Response::HTTP_OK, []);
    }

    /**
     * @Route("/user/{id}/workout/", name="test")
     */
    public function workout(Exercise $exercise, ExerciseRepository $exerciseRepository){

        $currentExercise = $exerciseRepository->find($exercise);

        return $this->json($currentExercise);
    }    



    /**
     * @Route("/user/{id}/workout/newPerf", name="newPerformance", methods={"POST"})
     */
    public function newPerf(Exercise $exercise, Request $request, SerializerInterface $serializer): Response
    {

        $jsonContent = $request->getContent();

        $newPerformance = $serializer->deserialize($jsonContent, Progress::class, 'json');


        $newPerformance->setUser();
        
        


    }

     /**
     * @Route("/user/{id}/workout/goal", name="goal", methods={"POST","PUT","PATCH"})
     */
    public function goal(): Response
    {
        return $this->render('user/index.html.twig');
    }

     /**
     * @Route("/register", name="register", methods={"POST"})
     */
    public function create(EntityManagerInterface $entityManager, Request $request, SerializerInterface $serializer, ValidatorInterface $validator, UserPasswordEncoderInterface $encoder) 
    {

        $jsonContent = $request->getContent();
        
        
        $user = $serializer->deserialize($jsonContent, User::class, 'json' );

        $passwordToHash = $user->getPassword();

        $passwordEncoded = $encoder->encodePassword($user, $passwordToHash);

        $user->setPassword($passwordEncoded);


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
        return $this->json(['message' => 'utilisateur crée'], Response::HTTP_CREATED);

    }


}
