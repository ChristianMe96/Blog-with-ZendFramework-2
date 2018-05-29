<?php
/**
 * Created by PhpStorm.
 * User: christian.meinhard
 * Date: 25.05.2018
 * Time: 08:31
 */

namespace Blog\Listener;


use Zend\EventManager\EventInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\ListenerAggregateTrait;
use Zend\Mvc\MvcEvent;
use Zend\Session\Container;

class LoginStatus implements ListenerAggregateInterface
{
    use ListenerAggregateTrait;
    
    public function attach(EventManagerInterface $events)
    {
        $this->listeners[] = $events->attach(MvcEvent::EVENT_DISPATCH, array($this, 'checkLoginStatus'));
    }

    public function checkLoginStatus(EventInterface $event)
    {
        $container = new Container('login');
        $valid = $container->valid;
        $viewModel = $event->getApplication()->getMvcEvent()->getViewModel();
        $viewModel->setVariable('valid', $valid);
    }

}