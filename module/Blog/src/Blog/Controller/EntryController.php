<?php
/**
 * Created by PhpStorm.
 * User: christian.meinhard
 * Date: 04.06.2018
 * Time: 10:14
 */

namespace Blog\Controller;


use Blog\Form\AddCommentForm;
use Blog\Form\DeleteForm;
use Blog\Form\EntryForm;
use Blog\InputFilter\CommentFilter;
use Blog\InputFilter\EntryFilter;
use Blog\Service\BlogService;
use Doctrine\ORM\EntityRepository;
use Zend\Form\Form;
use Zend\Http\Request;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Mvc\MvcEvent;
use Zend\Session\Container;
use Zend\View\Model\ViewModel;

class EntryController extends AbstractActionController
{
    private $entryRepo;
    private $blogService;
    private $commentRepo;

    public function onDispatch(MvcEvent $e)
    {
        return parent::onDispatch($e); // TODO: Change the autogenerated stub
    }


    public function __construct(EntityRepository $entryRepo, EntityRepository $commentRepo, BlogService $blogService)
    {
        $this->entryRepo = $entryRepo;
        $this->blogService = $blogService;
        $this->commentRepo = $commentRepo;
    }

    public function addAction()
    {
        $blogForm = new EntryForm();
        return $this->entryViewModel($blogForm, 'Add new Entry');
    }

    public function createEntryAction()
    {
        $entryForm = new EntryForm();
        $request = $this->getRequest();
        $entryFilter = new EntryFilter();
        $entryForm->setInputFilter($entryFilter->getInputFilter());
        $entryForm->setData($request->getPost());
        if ($entryForm->isValid()) {
            $this->blogService->addNewEntry($entryForm->getData());
            // Redirect to list of Entries
            return $this->redirect()->toRoute('home');
        }
        return $this->entryViewModel($entryForm, 'Add new Entry');
    }

    public function editAction()
    {
        //Get Entry ID
        $id = (int)$this->params()->fromRoute('id', 0);

        //Find existing Entry
        $entry = $this->entryRepo->find($id);

        $container = new Container('login');
        $userId = $container->userId;

        if ($entry->getAuthor()->getId() != $userId) {
            $this->redirect()->toRoute('home');
        }
        $tags = [];
        /** @var $tag \Blog\Entity\Tag */
        foreach ($entry->getTags() as $tag) {
            array_push($tags, $tag->getName());
        }

        //Create Form
        $form = new EntryForm();
        //in view schreiben
        $form->get('submit')->setAttribute('value', 'Edit');
        $form->get('title')->setValue($entry->getTitle());
        $form->get('content')->setValue($entry->getContent());
        $form->get('tags')->setValue(implode(',', $tags));

        return $this->entryViewModel($form, 'Edit Entry');
    }

    public function editEntryAction()
    {
        $id = (int)$this->params()->fromRoute('id', 0);
        $form = new EntryForm();
        $request = $this->getRequest();
        $entryFilter = new EntryFilter();
        $form->setInputFilter($entryFilter->getInputFilter());
        $form->setData($request->getPost());
        if ($form->isValid()) {
            $entry = $this->entryRepo->find($id);
            $this->blogService->editEntry($form->getData(), $entry);
            // Redirect to list of Entries
            return $this->redirect()->toRoute('home');
        }
        return $this->entryViewModel($form, 'Edit Entry');
    }

    public function deleteAction()
    {
        //Form
        $form = new DeleteForm();
        $id = (int)$this->params()->fromRoute('id', 0);
        $entry = $this->entryRepo->find($id);

        $container = new Container('login');
        $userId = $container->userId;

        if ($entry->getAuthor()->getId() != $userId) {
            $this->redirect()->toRoute('home');
        }
        //Im Service checken ob der user erlaub ist es zu löschen

        /** @var Request $request */
        $request = $this->getRequest();
        if ($request->isPost()) {
            $post = ($request->getPost('deleteYes', 'No') === "Yes");//No = default Value if DeleteYes is missing
            if ($post) {
                $this->blogService->deleteEntry($entry);
            }
            return $this->redirect()->toRoute('home');
        }
        return new ViewModel(['entry' => $entry, 'form' => $form, 'id' => $id]);
    }

    public function detailsAction()
    {
        $id = (int)$this->params()->fromRoute('id', 0);

        return $this->createDetailViewModel($id, new AddCommentForm());
    }

    public function addCommentAction()
    {
        $id = (int)$this->params()->fromRoute('id', 0);

        $request = $this->getRequest();
        $form = new AddCommentForm();
        $commentFilter = new CommentFilter();
        $form->setInputFilter($commentFilter->getInputFilter());
        $form->setData($request->getPost());
        if ($form->isValid()) {
            // Redirect to list of Entries
            $entry = $this->entryRepo->find($id);
            $this->blogService->addNewComment($form->getData(), $entry);
            return $this->redirect()->toRoute('entry/details/get', ['id' => $id]);
        }
        return $this->createDetailViewModel($id, $form);
    }


    private function createDetailViewModel(int $id, Form $form): ViewModel
    {
        $comments = $this->commentRepo->findBy(['entry' => $id]);
        $entry = $this->entryRepo->find($id);

        $viewModel = new ViewModel(['entry' => $entry, 'comments' => $comments, 'form' => $form, 'id' => $id]);
        $viewModel->setTemplate('blog/entry/details');
        return $viewModel;
    }

    private function entryViewModel(Form $form,string $title): ViewModel
    {
        $viewModel = new ViewModel(['form' => $form, 'title' => $title]);
        $viewModel->setTemplate('blog/entry/add-edit');
        return $viewModel;
    }
}