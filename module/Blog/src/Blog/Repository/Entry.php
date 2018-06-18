<?php
/**
 * Created by PhpStorm.
 * User: christian.meinhard
 * Date: 18.06.2018
 * Time: 11:21
 */

namespace Blog\Repository;


use Doctrine\ORM\EntityRepository;


class Entry extends EntityRepository
{
    public function findEntries()
    {
        $entityManager = $this->getEntityManager();

        $queryBuilder = $entityManager->createQueryBuilder();

        $queryBuilder->select('p')
            ->from(\Blog\Entity\Entry::class, 'e')
            ->orderBy('e.date', 'DESC');

        return $queryBuilder->getQuery();
    }
}