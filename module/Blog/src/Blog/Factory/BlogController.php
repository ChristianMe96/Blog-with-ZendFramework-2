<?php
namespace Blog\Factory;


use Blog\Entity\Comment;
use Blog\Entity\Entry;
use Blog\Entity\User;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class BlogController implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $sm = $serviceLocator->getServiceLocator();
        $entityManager = $sm->get("doctrine.entitymanager.orm_default");

        return new \Blog\Controller\BlogController(
            $entityManager->getRepository(Entry::class)
        );
    }
}