<?php

namespace App\Repository;

use App\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\Security\Core\User\UserInterface;
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
            ->orderBy('c.name', 'ASC')
            ->setFirstResult(($page - 1) * $limit)
            ->setMaxResults($limit)
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
