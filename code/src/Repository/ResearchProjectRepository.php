<?php

namespace App\Repository;

use App\Entity\ResearchProject;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ResearchProject>
 *
 * @method ResearchProject|null find($id, $lockMode = null, $lockVersion = null)
 * @method ResearchProject|null findOneBy(array $criteria, array $orderBy = null)
 * @method ResearchProject[]    findAll()
 * @method ResearchProject[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ResearchProjectRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ResearchProject::class);
    }

//    /**
//     * @return ResearchProject[] Returns an array of ResearchProject objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ResearchProject
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
