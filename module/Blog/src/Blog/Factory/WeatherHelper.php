<?php
/**
 * Created by PhpStorm.
 * User: christian.meinhard
 * Date: 25.07.2018
 * Time: 12:31
 */

namespace Blog\Factory;


use Blog\Service\WeatherService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class WeatherHelper implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $sm = $serviceLocator->getServiceLocator();
        /** @var WeatherService $weatherHelper */
        $weatherHelper = $sm->get(WeatherService::class);
        return new \Blog\View\Helper\WeatherHelper(
            $weatherHelper
        );
    }
}