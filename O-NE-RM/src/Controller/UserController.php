<?php

namespace App\Controller;


use App\Entity\User;
use App\Entity\Exercise;
use App\Entity\Goal;
use App\Entity\Progress;
use App\Repository\CommentRepository;
use App\Repository\ExerciseRepository;
use App\Repository\FitnessRoomRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


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
     * @Route("/api/user/{id}/edit", name="user", methods={"PUT","PATCH","POST"})
     */
    public function edit(User $user = null, EntityManagerInterface $em, SerializerInterface $serializer, Request $request, ValidatorInterface $validator, UserPasswordEncoderInterface $encoder ): Response
    {
        if ($user == null) {

            throw $this->createNotFoundException('utilisateur non trouvé');
        }

        $jsonContent = $request->getContent();

        $object = $serializer->deserialize($jsonContent, User::class, 'json', [AbstractNormalizer::OBJECT_TO_POPULATE => $user] );

        // $passwordHashed = $encoder->encodePassword($user, $user->getPassword());

        // $user->setPassword($passwordHashed);

        $error = $validator->validate($user);

        if (count($error) > 0) {

            return $this->json('erreur mon amis', Response::HTTP_UNPROCESSABLE_ENTITY);

        }

        $em->flush();

        return $this->json(['message' => 'User modifié.'], Response::HTTP_OK);
    }

    /**
     * Méthode permettant de créer un utilisateur en BDD
     * 
     * @Route("/register", name="register", methods={"POST"})
     */
    public function create(EntityManagerInterface $entityManager, Request $request, SerializerInterface $serializer, ValidatorInterface $validator, UserPasswordEncoderInterface $encoder, FitnessRoomRepository $fitnessRoomRepository ) 
    {
        // On recupere le contenu de la requete
        $jsonContent = $request->getContent();
        

        // ON recupere dans un tableau associatif tout le contenu JSON afin de recuperer le mot de passe de la salle transmis dans le formulaire vu qu'on ne pouvait pas le récuperer avec le deserializer
        $associativeArray = json_decode($jsonContent, true);

        // Maintenant qu'on a stocké le tableau associatif dans $associativeArray on peut deserializer (le deserializeur va ignorer le champ fitnessRomm_Password du JSON)
        $user = $serializer->deserialize($jsonContent, User::class, 'json' );


        if (!empty($associativeArray['fitnessRoom']) && $associativeArray['fitnessRoom'] !== '' ) {


            if (!empty($associativeArray['fitnessRoom_Password']) && $associativeArray['fitnessRoom_Password'] !== '' ) {
    
                $fitnessRoomPasswordToCheck = $associativeArray['fitnessRoom_Password'];
        
                // On recupere les infos de la salle séléctionnée
                $fitnessRoom = $fitnessRoomRepository->find($user->getFitnessRoom());
        
                // On recupere le mot de passe
                $goodFitnessRoomPassword = $fitnessRoom->getPassword();
        
                //On compare le mot de passe transmis avec le mot de passe en base => si pas ok on retourne une erreur sinon ok
                if(!password_verify($fitnessRoomPasswordToCheck,$goodFitnessRoomPassword)){
        
                    return $this->json('Le mot de passe de la salle est incorrect', Response::HTTP_NOT_ACCEPTABLE);
        
                }

            }
            else {

                return $this->json('veuillez entrer un mot de passe pour vous affilier à cette salle', Response::HTTP_NOT_ACCEPTABLE);
                
            }


        }

        //Désormais toute cette portion de code commentée est géree par le subscriber 

        //On recuperer le mot de passe du formulaire

        // $passwordToHash = $user->getPassword();

        // $passwordEncoded = $encoder->encodePassword($user, $passwordToHash);

        // $user->setPassword($passwordEncoded);


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


    // =============================== Partie Execices ================================================
    
    /**
     * Retourne un exercice en fonction de l'ID
     * 
     * @Route("/api/user/workout/{id}", name="test")
     */
    public function Oneworkout(Exercise $exercise = null, ExerciseRepository $exerciseRepository)
    {
        
        if ($exercise == null) {

            throw $this->createNotFoundException('exercice non trouvé.');
        }

        $currentExercise = $exerciseRepository->find($exercise);

        
        return $this->json($currentExercise, Response::HTTP_OK, [], ['groups' => 'workout_get']);

    }  


    // =============================== Partie Performances ================================================

    /**
     * Méthode permettant de retourner la liste des performances associées à un utilisateur et a un exercice
     * 
     * @Route("/api/user/workout/{id}/recap", name="performances")
     */
    public function performance(Exercise $exercise = null, ExerciseRepository $exerciseRepository): Response        
    {

        if ($exercise == null) {

            throw $this->createNotFoundException('exercice non trouvé.');
        }

        $user = $this->getUser();
        
        $lastPerformance = $exerciseRepository->OneExerciseWithUserProgress($user, $exercise);

        if($lastPerformance == []){

            $lastPerformance['user_id']        = $user->getId();
            $lastPerformance['ID_exercise']    = $exercise->getId();
            $lastPerformance['name']           = $exercise->getName();
            $lastPerformance['illustration']   = $exercise->getIllustration();
            $lastPerformance['advice']         = $exercise->getAdvice();
            $lastPerformance['difficulty']     = $exercise->getDifficulty();
            $lastPerformance['ID_progress']    = null;
            $lastPerformance['date']           = null;
            $lastPerformance['repetition']     = null;
            $lastPerformance['weight']         = null;

        }


        return $this->json($lastPerformance, Response::HTTP_OK, [], ['groups' => 'progressUser']);

    }
    
    /**
     * Méthode permettant d'obtenir que la derniere performance d'un exercice en fonction de l'utilisateur
     * 
     * @Route("/api/user/getLastPerformances", name="getLastPerf")
     */
    public function getLastPerformances(ExerciseRepository $exerciseRepository)
    {

        //la custom query trie les objects progress par date 'DESC' du coup en evitant les doublons on s'assure de ne récuperer que la derniere performance en date

        $lastPerformancesAndGoals = $exerciseRepository->ExerciseWithUserProgressAndGoals($this->getUser());
        
        $user = $this->getUser();

        $lastPerfAndGoalToSend = [];
        $checkExerciseID = [];
        

        //Ici on boucle sur les resultats pour ne recuperer que la derniere performance en date d'un exercice pour eviter de se retrouver avec des doublons de performance
        foreach ($lastPerformancesAndGoals as $last) {

            $exerciseID = $last['ID_exercise'];
            $last['user_id'] = $user->getId();

            if (!in_array($exerciseID, $checkExerciseID)) {

                $checkExerciseID[] = $exerciseID;


                $lastPerfAndGoalToSend[] = $last;

                
            }

        }

        return $this->json($lastPerfAndGoalToSend, Response::HTTP_OK, [], ['groups' => 'progressUser']);


    }
    


    /**
     * Méthode permettant d'ajouter une nouvelle performance en BDD
     * 
     * @Route("/api/user/workout/{id}/newPerf", name="newPerformance", methods={"POST"})
     */
    public function newPerf(Exercise $exercise = null, Request $request, SerializerInterface $serializer, EntityManagerInterface $entityManager, ValidatorInterface $validator): Response
    {

        if ($exercise == null) {

            throw $this->createNotFoundException('exercice non trouvé.');
        }

        $jsonContent = $request->getContent();

        $newPerformance = $serializer->deserialize($jsonContent, Progress::class, 'json');

        $newPerformance->setExercise($exercise);


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
         return $this->json(['message' => 'performance ajoutée'], Response::HTTP_CREATED);
        
        
    }

    // =============================== Partie Objectifs ================================================

    /**
     * Méthode permettant de récupérer les derniers objectifs d'un utilisateur (tous exercices confondus)
     * 
     * @Route("/api/user/getGoals", name="allgoals")
     */
    public function getLastGoals(ExerciseRepository $exerciseRepository)
    {
        
        $goalList = $exerciseRepository->getAllGoals($this->getUser());

        $lastGoalsToSend = [];
        $checkExerciseID = [];
        

        //Ici on boucle sur les resultats pour ne recuperer que la derniere performance en date d'un exercice pour eviter de se retrouver avec des doublons de performance
        foreach ($goalList as $goal) {

            $exerciseID = $goal['ID_exercise'];

            if (!in_array($exerciseID, $checkExerciseID)) {

                $checkExerciseID[] = $exerciseID;

                $lastGoalsToSend[] = $goal;
            }

        }

        return $this->json($lastGoalsToSend, Response::HTTP_OK,[], ['groups' => 'goals_get']);
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

    // =============================== Partie Commentaires ================================================

    /**
     * Méthode qui permet de récuperer les commentaires lié à un utilisateur et un exercice
     * 
     * @Route("/api/user/{id}/workout/getComment", name="getComment", methods={"GET", "POST"})
     */
    public function getComment(User $user = null, Request $request, CommentRepository $commentRepository, ExerciseRepository $exerciseRepository) 
    {

        if ($user == null) {

            throw $this->createNotFoundException('utilisateur non trouvé.');
        }

        $jsonContent = $request->getContent();

        $jsonDecoded = json_decode($jsonContent, true);

        $exerciseID = $jsonDecoded['exercise'];

        $exercise = $exerciseRepository->find($exerciseID);

        $commentList = $commentRepository->findBy(['user' => $user, 'exercise' => $exercise], ['id' => 'DESC'], 5);

        return $this->json($commentList, Response::HTTP_OK, [] , ['groups' => 'comment_get']);

    }

}
