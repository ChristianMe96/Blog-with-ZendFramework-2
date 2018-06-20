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
    public function getEntriesDesc()
    {
        $entityManager = $this->getEntityManager();

        $queryBuilder = $entityManager->createQueryBuilder();

        $queryBuilder->select('e')
            ->from(\Blog\Entity\Entry::class, 'e')
            ->orderBy('e.date', "DESC");

        return $queryBuilder->getQuery();
    }

    public function getWhereUsername($username)
    {
        $entityManager = $this->getEntityManager();
        $queryBuilder = $entityManager->createQueryBuilder();

        $queryBuilder->select('e')
            ->from(\Blog\Entity\Entry::class, 'e')
            ->innerJoin('e.authorId', 'u')
            ->where('u.username = :username')
            ->orderBy('e.date', "DESC")
            ->setParameter('username', $username);

        return $queryBuilder->getQuery();
    }

    public function getTagsSortedByFrequency()
    {
        $entityManager = $this->getEntityManager();
        $queryBuilder = $entityManager->createQueryBuilder();

        $queryBuilder->select('e.tags')
            ->from(\Blog\Entity\Entry::class, 'e');

        #var_dump($queryBuilder->getQuery());
        return $queryBuilder->getQuery();
    }
}