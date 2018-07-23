<?php
/**
 * Created by PhpStorm.
 * User: christian.meinhard
 * Date: 17.07.2018
 * Time: 15:21
 */

namespace Blog\Factory;


use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\ServiceManager;

class VisitorCounter implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $sm = $serviceLocator->get(ServiceManager::class);
        $blogService = $sm->get(\Blog\Service\BlogService::class);

        return new \Blog\Listener\VisitorCounter($blogService);
    }
}