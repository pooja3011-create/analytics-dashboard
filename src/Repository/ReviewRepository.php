<?php

namespace App\Repository;

use App\Entity\Review;
use App\Entity\Hotel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Review|null find($id, $lockMode = null, $lockVersion = null)
 * @method Review|null findOneBy(array $criteria, array $orderBy = null)
 * @method Review[]    findAll()
 * @method Review[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReviewRepository extends ServiceEntityRepository {

    public function __construct(ManagerRegistry $registry) 
    {
        parent::__construct($registry, Review::class);

        $emConfig = $this->getEntityManager()->getConfiguration();
        $emConfig->addCustomDatetimeFunction('MONTH', 'DoctrineExtensions\Query\Mysql\Month');
        $emConfig->addCustomDatetimeFunction('YEAR', 'DoctrineExtensions\Query\Mysql\Year');
        $emConfig->addCustomDatetimeFunction('WEEK', 'DoctrineExtensions\Query\Mysql\Week');
        $emConfig->addCustomDatetimeFunction('DAY', 'DoctrineExtensions\Query\Mysql\Week');
    }

    public function findByHotel($hotelid, $fromDate, $toDate, $groupBy) 
    {
        $qb = $this->createQueryBuilder('n');
        
        if ($groupBy == 'daily') {
            $findBy = 'DAY';
        }
        if ($groupBy == 'weekly') {
            $findBy = 'WEEK';
        }
        if ($groupBy == 'monthly') {
            $findBy = 'MONTH';
        }

      return $qb->select('count(n.comment) as review', 'avg(n.score) as score, count(n.score) as score_count', $findBy . 'n.created_date as Date')
                ->where('n.hotel = :hotelid')
                ->andWhere('n.created_date BETWEEN :from AND :to')
                ->groupBy('Date')
                ->setParameter('from', $from)
                ->setParameter('to', $to)
                ->setParameter('hotelid', $hotelid)
                ->getQuery()
                ->getResult();
    }

}
