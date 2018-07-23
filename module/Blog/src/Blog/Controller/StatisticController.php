<?php

namespace Blog\Controller;


use Blog\Repository\Visitor;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class StatisticController extends AbstractActionController
{
    private $visitorRepo;

    public function __construct(Visitor $visitorRepo)
    {
        $this->visitorRepo = $visitorRepo;
    }

    public function visitorChartAction()
    {
        $visitorPerDay = $this->visitorRepo->countVisitorsPerDay();

        return new ViewModel([
            "visitorsPerDay" => $visitorPerDay
        ]);
    }

}