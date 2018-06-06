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
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class EntryController extends AbstractActionController
{
    private $entryRepo;
    private $blogService;
    private $commentRepo;

    public function __construct(EntityRepository $entryRepo, EntityRepository $commentRepo, BlogService $blogService)
    {
        $this->entryRepo = $entryRepo;
        $this->blogService = $blogService;
        $this->commentRepo = $commentRepo;
    }

    public function addAction()
    {

        $blogForm = new EntryForm();
        $request = $this->getRequest();
        if ($request->isPost()) {
            $entryFilter = new EntryFilter();
            $blogForm->setInputFilter($entryFilter->getInputFilter());
            $blogForm->setData($request->getPost());
            if ($blogForm->isValid()) {
                $this->blogService->addNewEntry($blogForm->getData());
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
        //in view schreiben
        $form->get('submit')->setAttribute('value', 'Edit');
        $form->get('title')->setValue($entry->getTitle());
        $form->get('content')->setValue($entry->getContent());

        $request = $this->getRequest();
        if ($request->isPost()) {
            $entryFilter = new EntryFilter();
            $form->setInputFilter($entryFilter->getInputFilter());
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $this->blogService->editEntry($form->getData(), $entry);
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
                $this->blogService->deleteEntry($entry);
            }
            return $this->redirect()->toRoute('home');
        }
        return new ViewModel(['entry' => $entry, 'form' => $form, 'id' => $id]);
    }

    public function detailsAction()
    {
        //Get Entry ID
        $id = (int) $this->params()->fromRoute('id', 0);

        $comments = $this->commentRepo->findBy(['entryId' => $id]);
        $form = new AddCommentForm();
        if (count($comments) == 0) {
            $entry = $this->entryRepo->find($id);
        }else {
            $entry = $comments[0]->getEntryId();
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $entryFilter = new CommentFilter();
            $form->setInputFilter($entryFilter->getInputFilter());
            $form->setData($request->getPost());
            if ($form->isValid()) {
                // Redirect to list of Entries
                $this->blogService->addNewComment($form->getData(), $entry);
                return $this->redirect()->refresh();
            }

        }

        return new ViewModel(['entry' => $entry, 'comments' => $comments , 'form' => $form]);
    }
}