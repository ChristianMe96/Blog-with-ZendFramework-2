<?php

namespace Blog\Factory;


use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class BlogService implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $eventManager = $serviceLocator->get("doctrine.entitymanager.orm_default");;
        return new \Blog\Service\BlogService(
            $eventManager
        );
    }


}