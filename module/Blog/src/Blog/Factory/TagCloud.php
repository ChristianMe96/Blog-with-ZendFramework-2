<?php
/**
 * Created by PhpStorm.
 * User: christian.meinhard
 * Date: 23.07.2018
 * Time: 15:23
 */

namespace Blog\Factory;


use Doctrine\ORM\EntityManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class TagCloud implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $sm = $serviceLocator->getServiceLocator();
        /** @var EntityManager $eventManager */
        $eventManager = $sm->get("doctrine.entitymanager.orm_default");;
        return new \Blog\View\Helper\TagCloud(
            $eventManager
        );
    }

}