<?php

namespace App\Repository;

use App\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User as AppUser;

/**
 * @extends ServiceEntityRepository<Category>
 */
class CategoryRepository extends ServiceEntityRepository
{
    public function __construct(
        ManagerRegistry $registry,
        private EntityManagerInterface $em,
        private CategoryTypeRepository $ctRepository

        )
    {
        parent::__construct($registry, Category::class);
    }

    // public function paginatedCategories(string $searchfor): array
    // {
    //     return $this->createQueryBuilder('c')
    //         ->andWhere('LOWER(c.name) LIKE :val')
    //         ->setParameter('val', '%'.$searchfor.'%')
    //         ->getQuery()
    //         ->getResult()
    //     ;
    // }

    // example with query builder pagination
    public function paginatedCategories(int $page, int $limit, string $searchfor): array
    {
        return $this->createQueryBuilder('c')
            ->andWhere('LOWER(c.name) LIKE LOWER(:val)')
            ->setParameter('val', '%'.$searchfor.'%')
            ->orWhere('LOWER(c.description) LIKE LOWER(:val)')
            ->orderBy('c.name', 'ASC')
            ->setFirstResult(($page - 1) * $limit)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult()
        ;
    }

    public function categoriesAmount(string $searchfor): array
    {
        return $this->createQueryBuilder('c')
            ->andWhere('LOWER(c.name) LIKE LOWER(:val)')
            ->setParameter('val', '%'.$searchfor.'%')
            ->orderBy('c.name', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function usersCollection(int $userId, string $searchfor, int $page, int $limit): array
    {
        return $this->createQueryBuilder('c')
            ->andWhere('LOWER(c.name) LIKE LOWER(:val)')
            ->orWhere('LOWER(c.description) LIKE LOWER(:val)')
            ->andWhere('c.author = :author')
            ->setParameter('author', $userId)
            ->setParameter('val', '%'.$searchfor.'%')
            ->orderBy('c.name', 'ASC')
            ->setFirstResult(($page - 1) * $limit)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult()
        ;
    }

    public function usersCollectionAmount(int $userId, string $searchfor): array
    {
        return $this->createQueryBuilder('c')
            ->andWhere('LOWER(c.name) LIKE LOWER(:val)')
            ->andWhere('c.author = :author')
            ->setParameter('val', '%'.$searchfor.'%')
            ->setParameter('author', $userId)
            ->orderBy('c.name', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function deleteCategory(int $id): void
    {
        $category = $this->find($id);
        $this->em->remove($category);
        $this->em->flush();
    }

    public function checkUserAccess(AppUser $user, int $id)
    {
        $category = $this->find($id);

        return $category->getAuthor()->getId() === $user->getId();
    }

    public function mainPageCategories(): array
    {
        return $this->createQueryBuilder('c')
            ->orderBy('c.id', 'DESC')
            ->setMaxResults(5)
            ->getQuery()
            ->getResult()
        ;
    }
    
//    /**
//     * @return Category[] Returns an array of Category objects
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

//    public function findOneBySomeField($value): ?Category
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
