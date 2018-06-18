<?php
/**
 * Created by PhpStorm.
 * User: christian.meinhard
 * Date: 04.06.2018
 * Time: 10:13
 */

namespace Blog\Controller;


use Blog\Entity\User;
use Blog\Form\LoginForm;
use Blog\InputFilter\LoginFilter;
use Blog\Service\BlogService;
use Doctrine\ORM\EntityRepository;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Session\Container;

class UserController extends AbstractActionController
{
    private $userRepo;
    private $blogService;

    public function __construct(EntityRepository $userRepo, BlogService $blogService)
    {
        $this->userRepo = $userRepo;
        $this->blogService = $blogService;
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
            $userDb = $this->userRepo->findOneBy(['username' => $user->getUsername()]);
            if ($userDb != false && $user->getUsername() === $userDb->getUsername() && password_verify($user->getPassword(), $userDb->getPassword())){
                $container = new Container('login');
                $container->valid = true;
                $container->userId = $userDb->getId();
                // Redirect to list of Entries
                return $this->redirect()->toRoute('home');
            }
        }
        return $this->redirect()->toRoute('login');
    }

    public function loginAction()
    {
        $loginForm = new LoginForm();
        return array('form' => $loginForm, 'wrongloginData' => isset($wrongLoginData) ? $wrongLoginData : false);
    }

    public function logoutAction()
    {
        $container = new Container('login');
        $container->valid = false;
        return $this->redirect()->toRoute('home');
    }

    public function registrationAction()
    {
        $loginForm = new LoginForm();
        $request = $this->getRequest();
        $loginFilter = new LoginFilter();
        $loginForm->setInputFilter($loginFilter->getInputFilter());
        $loginForm->setData($request->getPost());
        if ($loginForm->isValid()) {
            $username = $loginForm->getData()['username'];
            if ($this->userRepo->findOneBy(['username' => $username])){
                return $this->redirect()->toRoute('register', ['error' => 'userExist']);
            }
            $this->blogService->addNewUser($loginForm->getData());
            return $this->redirect()->toRoute('login');
        }
        return $this->redirect()->toRoute('register', ['error' => 'notValid']);
    }

    public function registerAction()
    {
        $form = new LoginForm();
        $form->get('submit')->setAttribute('value', 'Register');
        $error = $this->params()->fromRoute('error', 0);
        switch ($error) {
            case 'userExist':
                $errorMessage = 'Username already exists!!';
                break;
            case 'notValid':
                $errorMessage = 'The Username or Password are not Valid!';
                break;
        }

        return ['form' => $form, 'errorMessage' => (!$errorMessage) ? $errorMessage : ""];
    }

}