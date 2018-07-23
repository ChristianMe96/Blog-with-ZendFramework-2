<?php
/**
 * Created by PhpStorm.
 * User: christian.meinhard
 * Date: 17.07.2018
 * Time: 14:05
 */

namespace Blog\Listener;


use Blog\Service\BlogService;
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
    private $blogService;

    public function __construct(BlogService $blogService)
    {
        $this->blogService = $blogService;
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

        $this->blogService->collectVisitorByIp($visitorIp);
    }

    public function injectVisitorCount(EventInterface $event)
    {
        $visitorCount = $this->blogService->getVisitorCount();

        $viewModel = $event->getApplication()->getMvcEvent()->getViewModel();
        $viewModel->setVariable('visitorCount', $visitorCount);
    }
}