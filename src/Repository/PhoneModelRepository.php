<?php

namespace App\Repository;

use App\Entity\PhoneModel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PhoneModel|null find($id, $lockMode = null, $lockVersion = null)
 * @method PhoneModel|null findOneBy(array $criteria, array $orderBy = null)
 * @method PhoneModel[]    findAll()
 * @method PhoneModel[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PhoneModelRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PhoneModel::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(PhoneModel $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(PhoneModel $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * Requête de récupération du stock total
     *
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function countStock()
    {

        return $this->createQueryBuilder('p')
            ->select('sum(p.stock) as totalStock')
            ->getQuery()
            ->getOneOrNullResult ();

    }


    // /**
    //  * @return PhoneModel[] Returns an array of PhoneModel objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PhoneModel
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
