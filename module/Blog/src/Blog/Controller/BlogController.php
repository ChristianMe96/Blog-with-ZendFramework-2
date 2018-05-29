<?php
/**
 * Created by PhpStorm.
 * User: christian.meinhard
 * Date: 14.05.2018
 * Time: 09:47
 */

namespace Blog\Controller;


use Blog\Form\DeleteForm;
use Blog\Form\EntryForm;
use Blog\Form\LoginForm;
use Blog\InputFilter\EntryFilter;
use Blog\InputFilter\LoginFilter;
use Blog\Entity\Entry;
use Blog\Entity\User;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Zend\Db\Sql\Delete;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Session\Container;
use Zend\View\Model\ViewModel;

class BlogController extends AbstractActionController
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $entryRepo;
    protected $userRepo;

    public function __construct(EntityRepository $entryRepo, EntityRepository $userRepo)
    {
        $this->entryRepo = $entryRepo;
        $this->userRepo = $userRepo;
        $blogEntry1 = new Entry();
        $blogEntry1->exchangeArray([
            'id' => 1,
            'title' => 'Test',
            'content' => 'Test Content',
            'date' => '14.05.2018 16:09',
            'author' => 1
        ]);
        $blogEntry2 = new Entry();
        $blogEntry2->exchangeArray([
            'id' => 2,
            'title' => 'Test2',
            'content' => 'Test Content2',
            'date' => '14.05.2018 20:09',
            'author' => 2
        ]);

        array_push($this->entries, $blogEntry1, $blogEntry2);

    }

    private $entries = [];

    public function indexAction()
    {
        //Todo: Factory!  Repository übergeben nur die die benötigt werden
        $entries = $this->entryRepo->findAll();

        return new ViewModel([
            'entries' => $entries,
        ]);

    }

    public function loginAction()
    {
        $loginForm = new LoginForm();
        $request = $this->getRequest();
        if ($request->isPost()) {
            $user = new User();
            $loginFilter = new LoginFilter();
            $loginForm->setInputFilter($loginFilter->getInputFilter());
            $loginForm->setData($request->getPost());

            if ($loginForm->isValid()) {
                $user->exchangeArray($loginForm->getData());
                $userDb = $this->userRepo->findOneBy(['username' => $user->getUsername()]);
                if ($user->getUsername() === $userDb->getUsername() && $user->getPassword() == $userDb->getPassword()){
                    $container = new Container('login');
                    $container->valid = true;
                    $container->userId = $userDb->getId();
                    // Redirect to list of Entries
                    return $this->redirect()->toRoute('home');
                }
            }

        }
        return array('form' => $loginForm);
    }

    public function addAction()
    {
        $container = new Container('login');
        $blogForm = new EntryForm();
        $request = $this->getRequest();
        if ($request->isPost()) {
            $entryFilter = new EntryFilter();
            $blogForm->setInputFilter($entryFilter->getInputFilter());
            $blogForm->setData($request->getPost());
            if ($blogForm->isValid()) {
                $entry = new Entry();
                $entry->exchangeArray($blogForm->getData());
                $entry->setAuthorId($container->userId);
                $entry->setDate(date('Y-m-d H:i:s'));
                $this->entryRepo->persist($entry);
                $this->entryRepo->flush();
                // Redirect to list of Entries
                return $this->redirect()->toRoute('home');
            }

        }
        return array('form' => $blogForm);
    }

    public function editAction()
    {
        //Get Entry ID
        $id = (int) $this->params()->fromRoute('id', 0);


        //Find existing Entry
        $entry = $this->entryRepo->find($id);

        //Create Form
        $form  = new EntryForm();
        $form->get('submit')->setAttribute('value', 'Edit');
        $form->get('title')->setValue($entry->getTitle());
        $form->get('content')->setValue($entry->getContent());
        $container = new Container('login');




        $request = $this->getRequest();
        if ($request->isPost()) {
            $entryFilter = new EntryFilter();
            $form->setInputFilter($entryFilter->getInputFilter());
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $entry->setTitle($form->getData()['title']);
                $entry->setContent($form->getData()['content']);
                $entry->setAuthorId($container->userId);
                $entry->setDate(date('Y-m-d H:i:s'));
                $this->entryRepo->flush();
                // Redirect to list of Entries
                return $this->redirect()->toRoute('home');
            }
        }
        return new ViewModel(['entry' => $entry, 'form' => $form, 'id' => $id]);
    }



    public function deleteAction()
    {
        //Form
        $form = new DeleteForm();
        $id = (int) $this->params()->fromRoute('id', 0);
        $entry = $this->entryRepo->find($id);
        $request = $this->getRequest();
        if ($request->isPost()){
            $post = $request->getPost('deleteYes', 'No');//No = default Value if DeleteYes is missing
            if ($post === 'Yes'){
                $this->entryRepo->remove($entry);
                $this->entryRepo->flush();
                return $this->redirect()->toRoute('home');
            }else {
                return $this->redirect()->toRoute('home');
            }
        }
        return new ViewModel(['entry' => $entry, 'form' => $form, 'id' => $id]);
    }

    public function logoutAction()
    {
        $container = new Container('login');
        $container->valid = false;
        return $this->redirect()->toRoute('home');
    }
}