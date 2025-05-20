<?php

namespace App\Repository;

use App\Entity\Library;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Library>
 */
class LibraryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Library::class);
    }
    /**
     * Find all producs having a value above the specified one with SQL.
     * 
     * @return [][] Returns an array of arrays (i.e. a raw data set)
     */
    public function findByValue($value): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            SELECT * FROM Library AS l
            WHERE l.isbn = :value
            ORDER BY l.isbn ASC
        ';

        $resultSet = $conn->executeQuery($sql, ['value' => $value]);

        return $resultSet->fetchAllAssociative();
    }


    //    /**
    //     * @return Library[] Returns an array of Library objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('l')
    //            ->andWhere('l.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('l.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Library
    //    {
    //        return $this->createQueryBuilder('l')
    //            ->andWhere('l.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
