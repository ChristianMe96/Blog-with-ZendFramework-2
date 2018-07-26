<?php
/**
 * Created by PhpStorm.
 * User: christian.meinhard
 * Date: 23.07.2018
 * Time: 13:53
 */

namespace Blog\Factory;


use Doctrine\ORM\EntityManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class VisitorService implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var EntityManager $eventManager */
        $eventManager = $serviceLocator->get("doctrine.entitymanager.orm_default");;
        return new \Blog\Service\VisitorService(
            $eventManager
        );
    }
}