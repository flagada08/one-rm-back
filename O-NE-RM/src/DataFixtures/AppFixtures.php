<?php

namespace App\DataFixtures;

use App\Entity\Exercise;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i <= 15; $i++){
            $exercise = new Exercise();
            $exercise->setName('exercise'.$i);
            $exercise->setDifficulty(mt_rand('1','5'));
            $exercise->setIllustration('toto'.$i.'.png');
            $exercise->setAdvice('blabla'.$i);
            $manager->persist($exercise);
        }
        
        $manager->flush();
    }
}
