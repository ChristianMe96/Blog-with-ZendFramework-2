<?php
namespace Blog\Factory;


use Blog\Entity\Entry;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class BlogController implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $sm = $serviceLocator->getServiceLocator();
        $entityManager = $sm->get("doctrine.entitymanager.orm_default");
        $blogService = $sm->get(\Blog\Service\BlogService::class);

        return new \Blog\Controller\BlogController(
            $entityManager->getRepository(Entry::class), $blogService
        );
    }
}