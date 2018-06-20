<?php

namespace Blog\Controller;



use Blog\Repository\Entry;

use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Paginator\Paginator;
use Zend\Session\Container;
use Zend\View\Model\ViewModel;

class BlogController extends AbstractActionController
{

    private $entryRepo;

    public function __construct(Entry $entryRepo)
    {
        $this->entryRepo = $entryRepo;
    }

    public function indexAction()
    {

        $page = (int) $this->params()->fromRoute('page', 1);


        $tagQuery = $this->entryRepo->getTagsSortedByFrequency();
        $tags = $tagQuery->getResult();
        var_dump($tags[0]['tags'][0]);

        $query = $this->entryRepo->getEntriesDesc();
        $adapter = new DoctrinePaginator(new ORMPaginator($query, false));
        $paginator = new Paginator($adapter);
        $container = new Container('login');
        $userId = $container->userId;
        $paginator->setCurrentPageNumber($page);
        $paginator->setItemCountPerPage(3);
        $pages = $paginator->getCurrentItems();

        return new ViewModel([
            'paginator' => $paginator, "pages" => $pages, "currentUserId" => $userId
        ]);

    }

    public function userEntriesAction()
    {
        $username = $this->params()->fromRoute('user');

        $page = (int) $this->params()->fromRoute('page', 1);

        $query = $this->entryRepo->getWhereUsername($username);
        $adapter = new DoctrinePaginator(new ORMPaginator($query, false));
        $paginator = new Paginator($adapter);
        $container = new Container('login');
        $userId = $container->userId;
        $paginator->setCurrentPageNumber($page);
        $paginator->setItemCountPerPage(3);
        $pages = $paginator->getCurrentItems();

        return new ViewModel([
            'paginator' => $paginator, "pages" => $pages, "currentUserId" => $userId
        ]);
    }
}