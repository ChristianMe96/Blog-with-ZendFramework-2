<?php
/**
 * Created by PhpStorm.
 * User: christian.meinhard
 * Date: 19.06.2018
 * Time: 08:44
 */

namespace Blog\Repository;


use Blog\Exception\UsernameAlreadyExists;
use Blog\Exception\WrongLoginCredentials;
use Doctrine\ORM\EntityRepository;
use Zend\Session\Container;

class User extends EntityRepository
{
    public function verifyLoginCredentials(\Blog\Entity\User $user) {

        $userFromDb = $this->findOneBy(['username' => $user->getUsername()]);
        if ($userFromDb != null &&$user->getUsername() === $userFromDb->getUsername() && password_verify($user->getPassword(), $userFromDb->getPassword())){
            $container = new Container('login');
            $container->valid = true;
            $container->userId = $userFromDb->getId();
        }else {
            throw new WrongLoginCredentials();
        }
    }
}