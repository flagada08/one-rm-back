<?php

namespace App\Repository;

use App\Entity\Exercise;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Exercise|null find($id, $lockMode = null, $lockVersion = null)
 * @method Exercise|null findOneBy(array $criteria, array $orderBy = null)
 * @method Exercise[]    findAll()
 * @method Exercise[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExerciseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Exercise::class);
    }

    // /**
    //  * @return Exercise[] Returns an array of Exercise objects
    //  */
    
    // public function findByExampleField($user)
    // {
    //     return $this->createQueryBuilder('e')
    //         ->LeftJoin('e.progress', 'p')
    //         ->addSelect('p')
    //         ->andwhere('p.user = :val')
    //         // ->andWhere('p.user = :val')
    //         ->setParameter('val', $user)
    //         // ->orderBy('p.date', 'DESC')
    //         ->getQuery()
    //         ->getResult();
    // }
    
    /**
     * Liste des exercices avec progres d'un utilisateur donné
     */
    
    public function ExerciseWithUserProgress($user)
    {
        $entityManager = $this->getEntityManager();

        $statement = $entityManager->getConnection()->prepare(

            'SELECT e.id AS ID_exercise, p.id AS ID_progress, e.name, p.date, p.repetition, p.weight, p.user_id
            FROM exercise AS e
            LEFT JOIN progress  AS p
            ON e.id = p.exercise_id
            AND p.user_id = :val
            ORDER BY ID_exercise ASC, p.date DESC');

        $statement->execute([
            'val' => $user->getId()
        ]);
        // returns an array of Product objects
        return $statement->fetchAll();

    }

    // Select * from exercise Left Join progress on exercise.id = progress.exercise_id and progress.user_id = 1


    /*
    public function findOneBySomeField($value): ?Exercise
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
