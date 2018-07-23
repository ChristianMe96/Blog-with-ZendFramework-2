<?php
/**
 * Created by PhpStorm.
 * User: christian.meinhard
 * Date: 17.07.2018
 * Time: 16:19
 */

namespace Blog\Repository;


use Doctrine\ORM\EntityRepository;

class Visitor extends EntityRepository
{
    public function countVisitorsForToday(): int
    {
        $entityManager = $this->getEntityManager();
        $queryBuilder = $entityManager->createQueryBuilder();

        $queryBuilder->select('count(v)')
            ->from(\Blog\Entity\Visitor::class,'v')
            ->where('v.date = :today')
            ->setParameter('today', date('Y-m-d'));

        $count = $queryBuilder->getQuery()->getSingleResult();

        return (int) reset($count);
    }

    public function countVisitorsPerDay(): array
    {
        $entityManager = $this->getEntityManager();
        $queryBuilder = $entityManager->createQueryBuilder();

        $queryBuilder->select('count(v) AS Visits, v.date AS Date')
            ->from(\Blog\Entity\Visitor::class, 'v')
            ->groupBy('v.date')
            ->orderBy('count(v)', 'DESC');

        $visitorsPerDay = $queryBuilder->getQuery()->getResult();

        return $visitorsPerDay;
    }
}