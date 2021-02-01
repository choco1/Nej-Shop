<?php

namespace App\Repository;

use App\Entity\Product;
use App\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

//INNER JOIN groupes g ON g.id = c.id
    public function findFilters($categoryId){

            $qb = $this->createQueryBuilder('p')
                ->innerJoin('p.category', 'c')
                ->andWhere('c = :categoryId')
                ->setParameter('categoryId', $categoryId );

//dump($qb->getQuery()->getResult());
            return $qb->getQuery()->getResult();

    }


    public function filterDate(){

        $qb = $this->createQueryBuilder('p')
            // select * from product orderby
            ->orderBy('p.date', 'DESC')
            ->setMaxResults(4)
            ->setFirstResult(0);

       //dump($qb->getQuery()->getResult());
        return $qb->getQuery()->getResult();
    }



    public function filtreFavorit(){

        $count = $this->count(['favorit' => true]);

        $qb = $this->createQueryBuilder('p')
            ->andWhere('p.favorit = 1')
            ->setMaxResults(1)
            ->setFirstResult(rand(0, $count - 1 ));


       // dump($count);
        return $qb->getQuery()->getResult();

    }



    public function findCaroussel(?int $limit = 4): ?iterable{

        $count = $this->count([]);

        $qb = $this->createQueryBuilder('p')
            ->setMaxResults($limit)
            ->setFirstResult(rand(0, $count - 1));

        return $qb->getQuery()->getResult();
    }



    public function findMNonte() {


        $qb = $this->createQueryBuilder('p')
            ->addSelect('AVG(pc.note)')
            ->innerJoin('p.comments', 'pc')
            ->orderBy('SUM(pc.note)', 'DESC')
            ->groupBy('p')
            ->setMaxResults(4);
            //->andWhere('pc = c');
           // ->setParameter('product', $product);
            //->andWhere('pc.note IN (5, 4)');

        dump($qb->getQuery()->getResult());
        return $qb->getQuery()->getResult();

    }


    // /**
    //  * @return Product[] Returns an array of Product objects
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
    public function findOneBySomeField($value): ?Product
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
