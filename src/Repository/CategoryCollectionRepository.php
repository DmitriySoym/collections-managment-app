<?php

namespace App\Repository;

use App\Entity\CategoryCollection;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CategoryCollection>
 */
class CategoryCollectionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CategoryCollection::class);
    }

    public function collectionItemsAmount(string $searchfor, int $catedoryId): array
    {
        return $this->createQueryBuilder('c')
            ->andWhere('LOWER(c.name) LIKE LOWER(:val)')
            ->orWhere('LOWER(c.description) LIKE LOWER(:val)')
            ->andWhere('c.categotyId = :category')
            ->setParameter('val', '%'.$searchfor.'%')
            ->setParameter('category', $catedoryId)
            ->orderBy('c.name', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

//    /**
//     * @return CategoryCollecction[] Returns an array of CategoryCollection objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?CategoryCollecction
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
