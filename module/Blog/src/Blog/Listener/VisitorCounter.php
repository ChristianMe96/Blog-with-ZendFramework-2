<?php
/**
 * Created by PhpStorm.
 * User: christian.meinhard
 * Date: 17.07.2018
 * Time: 14:05
 */

namespace Blog\Listener;


use Blog\Service\BlogService;
use Blog\Service\VisitorService;
use Zend\EventManager\EventInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\ListenerAggregateTrait;
use Zend\Http\PhpEnvironment\RemoteAddress;
use Zend\Http\Request;
use Zend\Mvc\MvcEvent;
use Zend\Session\Container;

class VisitorCounter implements ListenerAggregateInterface
{
    private $visitorService;

    public function __construct(VisitorService $visitorService)
    {
        $this->visitorService = $visitorService;
    }

    use ListenerAggregateTrait;

    public function attach(EventManagerInterface $events)
    {
        $this->listeners[] = $events->attach(MvcEvent::EVENT_DISPATCH, array($this, 'collectVisitor'));
        $this->listeners[] = $events->attach(MvcEvent::EVENT_DISPATCH, array($this, 'injectVisitorCount'));
    }

    public function collectVisitor(EventInterface $event)
    {
        /*$remoteAddress = new RemoteAddress();
        $remoteAddress->getIpAddress();*/

        $ipAddresses = [
            '127.0.0.1',
            '127.0.0.2',
            '127.0.0.3',
            '127.0.0.4',
            '127.0.0.5',
        ];

        $visitorIp = $ipAddresses[array_rand($ipAddresses)];

        $this->visitorService->collectVisitorByIp($visitorIp);
    }

    public function injectVisitorCount(EventInterface $event)
    {
        $visitorCount = $this->visitorService->getVisitorCount();

        $viewModel = $event->getApplication()->getMvcEvent()->getViewModel();
        $viewModel->setVariable('visitorCount', $visitorCount);
    }
}