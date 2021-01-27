<?php

namespace App\DataFixtures;

use App\Entity\FitnessRoom;
use Doctrine\DBAL\Connection;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class FitnessRoomFixtures extends Fixture
{

    private $passwordEncoder;


    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    private function truncate(Connection $connection)
    {
        // On passen mode SQL ! On cause avec MySQL

        // Désactivation des contraintes FK
        $users = $connection->query('SET foreign_key_checks = 0');

        // On tronque
        $users = $connection->query('TRUNCATE TABLE fitness_room');


        // etc.
    }

    public function load(ObjectManager $manager)
    {
        $this->truncate($manager->getConnection());



        // On créé des salles de sport fictives 

        for ($i = 0; $i <= 15; $i++){

            $fitnessRoom = new FitnessRoom();

            $fitnessRoom->setName('salle' . $i);
            $fitnessRoom->setPassword('salle' . $i);

            $manager->persist($fitnessRoom);
        }

        $manager->flush();
            

    }

            

}


