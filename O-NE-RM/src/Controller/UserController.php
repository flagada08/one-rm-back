<?php

namespace App\Controller;


use App\Entity\User;
use App\Entity\Exercise;
use App\Entity\Goal;
use App\Entity\Progress;
use App\Repository\UserRepository;
use App\Repository\ExerciseRepository;
use App\Repository\GoalRepository;
use App\Repository\ProgressRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserController extends AbstractController
{
    // =============================== Partie Utilisateur ================================================

    /**
     * Méthode permettant de retourner les informations utilisateur
     * 
     * @Route("/api/user/profil", name="profil")
     */
    public function profil(): Response
    {
        $user = $this->getUser();

        return $this->json($user,  Response::HTTP_OK, [], ['groups' => 'infos']);
    }

    /**
     * Méthode permettant de modifier les informations utilisateur
     * 
     * @Route("/api/user/{id}/edit", name="user", methods={"PUT","PATCH"})
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

    // =============================== Partie Execices ================================================
    
    /**
     * Retourne un exercice en fonction de l'ID
     * 
     * @Route("/api/user/{id}/workout/", name="test")
     */
    public function workout(Exercise $exercise, ExerciseRepository $exerciseRepository)
    {
        
        $currentExercise = $exerciseRepository->find($exercise);

        dd($currentExercise);
        
        return $this->json($currentExercise);

    }    
    

    // =============================== Partie Performances ================================================

    /**
     * Méthode permettant de retourner la liste des performances associées à un utilisateur et aux exercices
     * 
     * @Route("/api/user/performances", name="performances")
     */
    public function performance(ProgressRepository $progressRepository): Response        
    {
        
        $currentPerformances = $progressRepository->findBy(
            ['user' => $this->getuser() ]
        ); 


        return $this->json($currentPerformances, Response::HTTP_OK, [], ['groups' => 'progressUser']);

    }
    
    /**
     * Méthode permettant d'obtenir que la derniere performance d'un exercice en fonction de l'utilisateur
     * 
     * @Route("/api/user/getLastPerformances", name="getLastPerf")
     */
    public function getLastPerformances(ProgressRepository $progressRepository)
    {

        //la custom query trie les objects progress par date 'DESC' du coup en evitant les doublons on s'assure de ne récuperer que la derniere performance en date

        $lastPerformances = $progressRepository->findByExercise($this->getUser());

        $lastPerfToSend = [];
        $checkExerciseID = [];
        
        foreach ($lastPerformances as $progress) {

            $exercise = $progress->getExercise();

            $exerciseID = $exercise->getId();

            if (!in_array($exerciseID, $checkExerciseID)) {

                $checkExerciseID[] = $exerciseID;

                $lastPerfToSend[] = $progress;
            }

            
        }

        return $this->json($lastPerfToSend, Response::HTTP_OK, [], ['groups' => 'progressUser']);

        //TODO modifier la customQuery pour reussir a ne renvoyer que la derniere performance en date

    }
    


    /**
     * Méthode permettant d'ajouter une nouvelle performance en BDD
     * 
     * @Route("/api/user/{id}/workout/newPerf", name="newPerformance", methods={"POST"})
     */
    public function newPerf(Exercise $exercise, Request $request, SerializerInterface $serializer, EntityManagerInterface $entityManager, ValidatorInterface $validator): Response
    {

        $jsonContent = $request->getContent();

        $newPerformance = $serializer->deserialize($jsonContent, Progress::class, 'json');

         //  On valide l'entité désérialisée
         $errors = $validator->validate($newPerformance);

         // Si nombre d'erreur > 0 alors on renvoie une erreur
         if (count($errors) > 0) {
 
             // On retourne le tableau d'erreurs en Json au front avec un status code 422
             return $this->json('ca marche pas', Response::HTTP_UNPROCESSABLE_ENTITY);
             
         }
         
         // On persiste les données
         $entityManager->persist($newPerformance);
 
         // On flush pour enregistrer en BDD
         $entityManager->flush();
 
         // REST nous dit : status 201 + Location: movies/{id}
         return $this->json(['message' => 'performance ajoutée en base'], Response::HTTP_CREATED);
        
        
    }

    // =============================== Partie Objectifs ================================================

    /**
     * Méthode permettant de récupérer tous les objectifs d'un utilisateur (tous exercices confondus)
     * 
     * @Route("/api/user/{id}/workout/allgoals", name="allgoals")
     */
    public function getAllGoals(User $user, GoalRepository $goal)
    {
        $goalList = $goal->findBy(['user' => $user]);


        return $this->json($goalList, Response::HTTP_OK,[], ['groups' => 'goals_get']);
    }

    /**
     * Méthode qui permet de recuperer l'objectif lié à  l'exercice de l'utilsateur connecté 
     *
     * @Route("/api/user/workout/{id}/goal")
     */
    public function getGoalForExercise()
    {

        $user = $this->getUser;

        return $this->json('coucou');

    }

    /**
     * Méthode qui permet d'ajouter un objectif en BDD
     * 
     * @Route("/api/user/{id}/workout/goal", name="goal", methods={"POST","PUT","PATCH"})
     */
    public function newGoal(Request $request, SerializerInterface $serializer, ValidatorInterface $validator, EntityManagerInterface $entityManager): Response
    {
        
        $jsonContent = $request->getContent();
        
        $goal = $serializer->deserialize($jsonContent, Goal::class, 'json' );
       
        $errors = $validator->validate($goal);

        // Si nombre d'erreur > 0 alors on renvoie une erreur
        if (count($errors) > 0) {
            // On retourne le tableau d'erreurs en Json au front 
            return $this->json('ça ne fonctionne pas', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $entityManager->persist($goal);

        $entityManager->flush();

        return $this->json(['message' => 'L\'objectif a été créé'], Response::HTTP_CREATED);

        //TODO a checker et a modifier pour put et patch
    }

    /**
     * Méthode permettant de créer un utilisateur en BDD
     * 
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
