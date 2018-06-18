<?php

namespace Blog\Controller;


use Blog\Form\DeleteForm;
use Blog\Form\EntryForm;
use Blog\Form\LoginForm;
use Blog\InputFilter\EntryFilter;
use Blog\InputFilter\LoginFilter;
use Blog\Entity\User;
use Blog\Service\BlogService;
use Doctrine\ORM\EntityRepository;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Paginator\Adapter\ArrayAdapter;
use Zend\Paginator\Paginator;
use Zend\Session\Container;
use Zend\View\Model\ViewModel;

class BlogController extends AbstractActionController
{

    private $entryRepo;

    public function __construct(EntityRepository $entryRepo)
    {
        $this->entryRepo = $entryRepo;
    }

    public function indexAction()
    {

        $page = (int) $this->params()->fromRoute('page', 0);

        $entry = $this->entryRepo->findAll();

        $adapter = new DoctrinePaginator(new \Doctrine\ORM\Tools\Pagination\Paginator($entry, false));
        $paginator = new Paginator(new ArrayAdapter($entry));
        $paginator->setCurrentPageNumber($page);
        $paginator->setItemCountPerPage(3);
        $pages = $paginator->getPages();
        return new ViewModel([
            'paginator' => $paginator, "pages" => $pages
        ]);

    }
}