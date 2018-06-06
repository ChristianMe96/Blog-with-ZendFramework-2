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
use Zend\Mvc\Controller\AbstractActionController;
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
        //Todo: Factory!  Repository übergeben nur die die benötigt werden !Done!
        $entries = $this->entryRepo->findAll();

        return new ViewModel([
            'entries' => $entries,
        ]);

    }
}