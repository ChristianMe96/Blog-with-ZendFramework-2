<?php
/**
 * Created by PhpStorm.
 * User: christian.meinhard
 * Date: 24.05.2018
 * Time: 09:11
 */

namespace Blog\Form;

use Zend\Form\Element;
use Zend\Form\Form;

class LoginForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('login');

        $titleInput = new Element\Text();
        $titleInput->setName('username');
        $titleInput->setLabel('Username');
        $titleInput->setAttribute('class','form-control');

        $this->add($titleInput);

        $passwordInput = new Element\Password();
        $passwordInput->setName('password');
        $passwordInput->setLabel('Password');
        $passwordInput->setAttribute('class','form-control');
        $this->add($passwordInput);
/*
        $authorInput = new Element\Checkbox();
        $authorInput->setName('author');
        $authorInput->setLabel('Author');
        $this->add($authorInput);
*/

        $submit = new Element\Submit();
        $submit->setName('submit');
        $submit->setValue('Login');
        $submit->setAttribute('class','btn  btn-default');
        $this->add($submit);

    }
}