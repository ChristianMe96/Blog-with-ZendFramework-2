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
use Doctrine\ORM\EntityRepository;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Session\Container;

class LoginController extends AbstractActionController
{
    private $userRepo;

    public function __construct(EntityRepository $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function loginPostAction()
    {
        $request = $this->getRequest();
        $loginForm = new LoginForm();
        $loginFilter = new LoginFilter();
        $loginForm->setInputFilter($loginFilter->getInputFilter());
        $loginForm->setData($request->getPost());
        if ($loginForm->isValid()) {
            $user = new User();
            $user->setUsername($loginForm->getData()['username'])->setPassword($loginForm->getData()['password']);
            $userDb = $this->userRepo->findOneBy(['username' => $user->getUsername()]);
            if ($user->getUsername() === $userDb->getUsername() && $user->getPassword() == $userDb->getPassword()){
                $container = new Container('login');
                $container->valid = true;
                $container->userId = $userDb->getId();
            }
            return $this->redirect()->toRoute('home');
        }
        return $this->redirect()->toRoute('home');
    }

    public function loginAction()
    {
        $loginForm = new LoginForm();
        return array('form' => $loginForm);
    }


    public function logoutAction()
    {
        $container = new Container('login');
        $container->valid = false;
        return $this->redirect()->toRoute('home');
    }


}