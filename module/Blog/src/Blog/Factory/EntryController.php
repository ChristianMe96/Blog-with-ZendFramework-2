<?php
/**
 * Created by PhpStorm.
 * User: christian.meinhard
 * Date: 04.06.2018
 * Time: 10:38
 */

namespace Blog\Factory;


use Blog\Entity\Comment;
use Blog\Entity\Entry;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class EntryController implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $sm = $serviceLocator->getServiceLocator();
        $entityManager = $sm->get("doctrine.entitymanager.orm_default");
        $blogService = $sm->get(\Blog\Service\BlogService::class);

        return new \Blog\Controller\EntryController(
            $entityManager->getRepository(Entry::class), $entityManager->getRepository(Comment::class) , $blogService
        );
    }
}