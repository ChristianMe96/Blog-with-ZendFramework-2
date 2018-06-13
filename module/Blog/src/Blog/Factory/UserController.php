<?php

namespace Blog\Factory;


use Blog\Entity\User;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class UserController implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $sm = $serviceLocator->getServiceLocator();
        $entityManager = $sm->get("doctrine.entitymanager.orm_default");
        $blogService = $sm->get(\Blog\Service\BlogService::class);

        return new \Blog\Controller\UserController(
            $entityManager->getRepository(User::class), $blogService
        );
    }
}
