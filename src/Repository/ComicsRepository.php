<?php

namespace App\Repository;

use App\Entity\Comics;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Comics>
 *
 * @method Comics|null find($id, $lockMode = null, $lockVersion = null)
 * @method Comics|null findOneBy(array $criteria, array $orderBy = null)
 * @method Comics[]    findAll()
 * @method Comics[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ComicsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Comics::class);
    }

    public function add(Comics $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Comics $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @param string|null string to find in comics
     * @return Comics[] Returns an array of Comics objects
     */
    public function findAllOrderByTitleSearch(?string $search = null): array
    {
        return $this->createQueryBuilder('c')
            ->orderBy('c.title', 'ASC')
            ->where('c.title LIKE :search')
            ->setParameter('search', '%' . $search . '%')
            ->getQuery()
            ->getResult();
    }

    /**
    * @return Comics[] Returns an array of nine Comics objects
    */
    public function findNineComics($limit = 9)
    {
        return $this->createQueryBuilder('c')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

//    /**
//     * @return Comics[] Returns an array of Comics objects
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

//    public function findOneBySomeField($value): ?Comics
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
