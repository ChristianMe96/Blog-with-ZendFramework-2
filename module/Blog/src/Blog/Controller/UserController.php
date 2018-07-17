<?php
/**
 * Created by PhpStorm.
 * User: christian.meinhard
 * Date: 04.06.2018
 * Time: 10:13
 */

namespace Blog\Controller;


use Blog\Entity\User;
use Blog\Exception\UsernameAlreadyExists;
use Blog\Exception\WrongLoginCredentials;
use Blog\Form\LoginForm;
use Blog\InputFilter\LoginFilter;
use Blog\Service\BlogService;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Session\Container;
use Zend\View\Model\ViewModel;

class UserController extends AbstractActionController
{
    private $userRepo;
    private $blogService;

    public function __construct(\Blog\Repository\User $userRepo, BlogService $blogService)
    {
        $this->userRepo = $userRepo;
        $this->blogService = $blogService;
    }

    public function loginAction()
    {
        $loginForm = new LoginForm();
        return $this->userViewModel($loginForm, 'Login');
    }

    public function processLoginAction()
    {
        $loginForm = new LoginForm();
        $request = $this->getRequest();
        $loginFilter = new LoginFilter();
        $loginForm->setInputFilter($loginFilter->getInputFilter());
        $loginForm->setData($request->getPost());
        if ($loginForm->isValid()) {
            $user = new User();
            $user->setUsername($loginForm->getData()['username'])->setPassword($loginForm->getData()['password']);
            try {
                $this->userRepo->verifyLoginCredentials($user);
                return $this->redirect()->toRoute('home');
            }catch (WrongLoginCredentials $w){
                $this->flashMessenger()->setNamespace('error')->addMessage('Wrong Username or Password !!');
            }
        }
        return $this->userViewModel($loginForm, 'Login');
    }

    public function registerAction()
{
    $form = new LoginForm();
    $form->get('submit')->setAttribute('value', 'Register');

    return $this->userViewModel($form, 'Register');
}

    public function registrationAction()
    {
        $loginForm = new LoginForm();
        $request = $this->getRequest();
        $loginFilter = new LoginFilter();
        $loginForm->setInputFilter($loginFilter->getInputFilter());
        $loginForm->setData($request->getPost());
        if ($loginForm->isValid()) {
            try {
                $this->blogService->addNewUser($loginForm->getData());
            }catch (UsernameAlreadyExists $e){
                $this->flashMessenger()->setNamespace('error')->addMessage('Username already exists!');
            }
            return $this->redirect()->toRoute('login/get');
        }
        #$this->flashMessenger()->setNamespace('error')->addMessage('The Username or Password are not Valid!');
        return $this->userViewModel($loginForm, 'Register');
    }

    public function logoutAction()
    {
        $container = new Container('login');
        $container->valid = false;
        $container->userId = null;
        return $this->redirect()->toRoute('home');
    }

    private function userViewModel($form, $title)
    {
        $viewModel = new ViewModel(['form' => $form, 'title' => $title]);
        $viewModel->setTemplate('blog/user/login');
        return $viewModel;
    }

}