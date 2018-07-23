<?php
/**
 * Created by PhpStorm.
 * User: christian.meinhard
 * Date: 20.07.2018
 * Time: 13:27
 */

namespace Blog\Factory;


use Blog\Entity\Visitor;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class StatisticController implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $sm = $serviceLocator->getServiceLocator();
        $entityManager = $sm->get("doctrine.entitymanager.orm_default");
        #$blogService = $sm->get(\Blog\Service\BlogService::class);

        return new \Blog\Controller\StatisticController(
            $entityManager->getRepository(Visitor::class)
        );
    }
}