<?php

namespace App\Repository;

use App\Entity\JournalEntry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method JournalEntry|null find($id, $lockMode = null, $lockVersion = null)
 * @method JournalEntry|null findOneBy(array $criteria, array $orderBy = null)
 * @method JournalEntry[]    findAll()
 * @method JournalEntry[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class JournalEntryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, JournalEntry::class);
    }

    // /**
    //  * @return JournalEntry[] Returns an array of JournalEntry objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('j')
            ->andWhere('j.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('j.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?JournalEntry
    {
        return $this->createQueryBuilder('j')
            ->andWhere('j.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
