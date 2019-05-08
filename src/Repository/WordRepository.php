<?php

namespace App\Repository;

use App\Entity\Word;
use App\Entity\WordList;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Word|null find($id, $lockMode = null, $lockVersion = null)
 * @method Word|null findOneBy(array $criteria, array $orderBy = null)
 * @method Word[]    findAll()
 * @method Word[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WordRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Word::class);
    }
    
    public function isExistAtList(Word $word): bool
    {
        $isExist = $this->createQueryBuilder('word')
            ->andWhere('word.english = :engVal')
            ->setParameter('engVal', $word->getEnglish())
            ->andWhere('word.user = :user')
            ->setParameter('user', $word->getUser())
            ->andWhere('word.list = :list')
            ->setParameter('list', $word->getList())
            ->getQuery()
            ->getOneOrNullResult();
        
        return isset($isExist);
    }
    
    /**
     * @param string $sort
     * @param string $order
     * @param WordList $list
     * @return Word[]|null
     */
    protected function getAllFromListBy(string $sort, string $order, WordList $list): ?array
    {
        if (!isset($list)) {
            return null;
        }
        
        $words = $this->createQueryBuilder('word')
            ->andWhere('word.user = :user')
            ->setParameter('user', $list->getUser())
            ->andWhere('word.list = :list')
            ->setParameter('list', $list)
            ->orderBy('word.' . $sort, $order)
            ->getQuery()
            ->getArrayResult();
        
        return $words;
    }
    
    /**
     * @param WordList $list
     * @return Word[]|null
     */
    public function getAllFromListByAlphabet(WordList $list): ?array
    {
        return $this->getAllFromListBy('english', 'ASC', $list);
    }
    
    /**
     * @param WordList $list
     * @return Word[]|null
     */
    public function getAllFromListById(WordList $list): ?array
    {
        return $this->getAllFromListBy('id', 'ASC', $list);
    }
    
    /**
     * @param WordList $list
     * @return array|null
     */
    public function getAllFromListByIdDESC(WordList $list): ?array
    {
        return $this->getAllFromListBy('id', 'DESC', $list);
    }
    
    // /**
    //  * @return Word[] Returns an array of Word objects
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
    public function findOneBySomeField($value): ?Word
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
