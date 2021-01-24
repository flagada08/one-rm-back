<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Exercise;
use App\Entity\FitnessRoom;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use App\DataFixtures\Provider\OneRmProvider;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        //On va créer les exercices avec l'aide du provider
        
        for ($i = 1; $i <= 16; $i++){

            $provider = new OneRmProvider;

            $exercise = new Exercise();

            $exercise->setName($provider->ExerciseName($i));
            $exercise->setDifficulty($provider->difficulty($i));
            $exercise->setIllustration('toto'.$i.'.png');
            $exercise->setAdvice($provider->advice($i));

            $manager->persist($exercise);
        }

        // On créé des salles de sport fictives 

        for ($i = 1; $i <= 16; $i++){

            $fitnessRoom = new FitnessRoom();

            $fitnessRoom->setName('salle' . $i);
            $fitnessRoom->setPassword('password' . $i);

            $manager->persist($fitnessRoom);
        }

        // on créé des utilisateur fictifs

        for ($i = 1; $i <= 16; $i++){

            $user = new User();

            $gender = ['homme', 'femme'];

            $user->setFirstName('prenom' . $i);
            $user->setLastname('nom' . $i);
            $user->setGender(array_rand($gender));
            $user->setAge(mt_rand(15,99));
            $user->setEmail('toto' . $i . '@email.com');
            $user->setPassword('password' . $i);
            $user->setRoles(['ROLE_USER']);


            $manager->persist($user);
        }

        
        $manager->flush();
    }
}
