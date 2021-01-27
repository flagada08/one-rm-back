<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\DBAL\Connection;
use App\Repository\UserRepository;
use App\Repository\ExerciseRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use App\DataFixtures\Provider\OneRmProvider;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{

    private $passwordEncoder;


    public function __construct(UserRepository $userRepository, ExerciseRepository $exerciseRepository, UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->userRepository = $userRepository;
        $this->exerciseRepository = $exerciseRepository;
        $this->passwordEncoder = $passwordEncoder;
    }

    private function truncate(Connection $connection)
    {
        // On passen mode SQL ! On cause avec MySQL

        // Désactivation des contraintes FK
        $users = $connection->query('SET foreign_key_checks = 0');

        // On tronque
        $users = $connection->query('TRUNCATE TABLE user');


        // etc.
    }

    public function load(ObjectManager $manager)
    {
        $this->truncate($manager->getConnection());

        // on créé des utilisateurs fictifs

        for ($i = 1; $i <= 9 ; $i++) {
            $user = new User();

            $gender = ['homme', 'femme'];

            $provider = new OneRmProvider;

            $user->setFirstName($provider->username($i));
            $user->setLastname($provider->username($i));
            $user->setGender(array_rand($gender));
            $user->setAge(mt_rand(15, 99));
            $user->setEmail($provider->username($i). '@' . $provider->username($i) . '.com');
            $user->setPassword($this->passwordEncoder->encodePassword($user, $provider->username($i)));
            $user->setRoles(['ROLE_USER']);


            $manager->persist($user);

        }

            $manager->flush();

    }

}
