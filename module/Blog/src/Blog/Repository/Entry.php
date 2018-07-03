<?php
/**
 * Created by PhpStorm.
 * User: christian.meinhard
 * Date: 18.06.2018
 * Time: 11:21
 */

namespace Blog\Repository;


use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;


class Entry extends EntityRepository
{
    public function getEntriesWithLimit($currentPage , $limit)
    {
        $entityManager = $this->getEntityManager();

        $queryBuilder = $entityManager->createQueryBuilder();

        $queryBuilder->select('e')
            ->from(\Blog\Entity\Entry::class, 'e')
            ->orderBy('e.date', "DESC")
            ->setFirstResult($limit * ($currentPage -1))//offset
            ->setMaxResults($limit);//limit;

        return $queryBuilder->getQuery();
    }

    public function getWhereUsername($username)
    {
        $entityManager = $this->getEntityManager();
        $queryBuilder = $entityManager->createQueryBuilder();

        $queryBuilder->select('e')
            ->from(\Blog\Entity\Entry::class, 'e')
            ->innerJoin('e.author', 'u')
            ->where('u.username = :username')
            ->orderBy('e.date', "DESC")
            ->setParameter('username', $username);

        return $queryBuilder->getQuery();
    }

    public function findEntriesWithTags()
    {
        $entityManager = $this->getEntityManager();
        $queryBuilder = $entityManager->createQueryBuilder();

        $queryBuilder->select('e')
            ->from(\Blog\Entity\Entry::class, 'e')
            ->join('e.tags', 't')
            ->orderBy('e.date', 'DESC');


        return $queryBuilder->getQuery();
    }

    public function findEntriesByTag($tagName)
    {
        $entityManager = $this->getEntityManager();

        $queryBuilder = $entityManager->createQueryBuilder();

        $queryBuilder->select('e')
            ->from(\Blog\Entity\Entry::class, 'e')
            ->join('e.tags', 't')
            ->andWhere('t.name = :tagName')
            ->orderBy('e.date', 'DESC')
            ->setParameter('tagName', $tagName);

        return $queryBuilder->getQuery();
    }
}