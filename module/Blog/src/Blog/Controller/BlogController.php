<?php

namespace Blog\Controller;



use Blog\Repository\Entry;

use Blog\Service\BlogService;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Paginator\Paginator;
use Zend\Session\Container;
use Zend\View\Model\ViewModel;

class BlogController extends AbstractActionController
{

    private $entryRepo;

    private $blogService;

    public function __construct(Entry $entryRepo, BlogService $blogService)
    {
        $this->entryRepo = $entryRepo;
        $this->blogService = $blogService;
    }


    public function indexAction()
    {
        $tagFilter = $this->params()->fromRoute('tag', null);

        $page = (int) $this->params()->fromRoute('page', 1);

        if ($tagFilter) {
            $query = $this->entryRepo->findEntriesByTag($tagFilter);
        }else {
            $query = $this->entryRepo->getEntriesWithLimit($page, 3);
        }

        $adapter = new DoctrinePaginator(new \Doctrine\ORM\Tools\Pagination\Paginator($query, false));
        $paginator = new Paginator($adapter);
        $container = new Container('login');
        $userId = $container->userId;
        $paginator->setCurrentPageNumber($page);
        $paginator->setItemCountPerPage(3);


        $tagCloud = $this->blogService->getTagCloud();


        return new ViewModel([
            'paginator' => $paginator, "currentUserId" => $userId, 'tagCloud' => $tagCloud
        ]);

    }

    public function userEntriesAction()
    {
        $username = $this->params()->fromRoute('user');

        $page = (int) $this->params()->fromRoute('page', 1);

        $query = $this->entryRepo->getWhereUsername($username);
        $adapter = new DoctrinePaginator(new \Doctrine\ORM\Tools\Pagination\Paginator($query, false));
        $paginator = new Paginator($adapter);
        $container = new Container('login');
        $userId = $container->userId;
        $paginator->setCurrentPageNumber($page);
        $paginator->setItemCountPerPage(3);

        $tagCloud = $this->blogService->getTagCloud();

        return new ViewModel([
            'paginator' => $paginator, "username" => $username, "currentUserId" => $userId,'tagCloud' => $tagCloud
        ]);
    }
}