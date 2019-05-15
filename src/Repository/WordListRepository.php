<?php

namespace App\Repository;

use App\Entity\User;
use App\Entity\WordList;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method WordList|null find($id, $lockMode = null, $lockVersion = null)
 * @method WordList|null findOneBy(array $criteria, array $orderBy = null)
 * @method WordList[]    findAll()
 * @method WordList[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WordListRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, WordList::class);
    }
    
    /**
     * @param User $user
     * @param string $orderBy
     * @param bool $asc
     * @return WordList[]
     */
    protected function getListsBy(User $user, string $orderBy, bool $asc = false): array
    {
        return $this->createQueryBuilder('wl')
            ->andWhere('wl.user = :user')
            ->setParameter('user', $user)
            ->orderBy('wl.' . $orderBy, $asc ? 'ASC' : 'DESC')
            ->getQuery()
            ->getResult();
    }
    
    /**
     * @param User $user
     * @param bool $ascending
     * @return WordList[]
     */
    public function getListsByTrainingDate(User $user, bool $ascending = false): array
    {
        return $this->getListsBy($user, 'lastAccessDate', $ascending);
    }
    
    // /**
    //  * @return WordList[] Returns an array of WordList objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('w.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */
    
    /*
    public function findOneBySomeField($value): ?WordList
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
