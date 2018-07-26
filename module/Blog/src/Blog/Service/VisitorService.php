<?php
/**
 * Created by PhpStorm.
 * User: christian.meinhard
 * Date: 23.07.2018
 * Time: 13:36
 */

namespace Blog\Service;


use Blog\Entity\Visitor;
use Doctrine\ORM\EntityManager;

class VisitorService
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function collectVisitorByIp(string $visitorsIp): void
    {
        $visitorRepo = $this->entityManager->getRepository(Visitor::class);
        $visitor = $visitorRepo->findBy(['ip' => $visitorsIp, 'date' => date('Y-m-d')]);

        if (!$visitor) {
            $visitor = new Visitor();
            $visitor->setIp($visitorsIp);
            $visitor->setDate(date('Y-m-d'));

            $this->entityManager->persist($visitor);
            $this->entityManager->flush();
        }
    }

    public function getVisitorCount(): int
    {
        /** @var \Blog\Repository\Visitor $visitorRepo */
        $visitorRepo = $this->entityManager->getRepository(Visitor::class);

        return $visitorRepo->countVisitorsForToday();
    }
}