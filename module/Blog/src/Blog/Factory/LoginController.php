<?php
/**
 * Created by PhpStorm.
 * User: christian.meinhard
 * Date: 04.06.2018
 * Time: 10:29
 */

namespace Blog\Factory;


use Blog\Entity\User;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class LoginController implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $sm = $serviceLocator->getServiceLocator();
        $entityManager = $sm->get("doctrine.entitymanager.orm_default");

        return new \Blog\Controller\LoginController(
            $entityManager->getRepository(User::class)
        );
    }
}