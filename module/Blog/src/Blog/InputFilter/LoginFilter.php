<?php
/**
 * Created by PhpStorm.
 * User: christian.meinhard
 * Date: 24.05.2018
 * Time: 11:47
 */

namespace Blog\InputFilter;

use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\InputFilter\Input;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Zend\Validator\NotEmpty;
use Zend\Validator\StringLength;


class LoginFilter implements InputFilterAwareInterface
{
    protected $inputFilter;


    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used");
    }
    public function getInputFilter()
    {
        if (!$this->inputFilter) {



            $inputFilter = new InputFilter();

            $notEmpty = new NotEmpty();
            $notEmpty->setMessage('Darf nicht leer sein!');

            $stringLengthUsername = new StringLength();
            $stringLengthUsername->setMax(18)->setMin(3)->setEncoding('UTF-8');
            $stringLengthUsername->setMessage('Username muss zwischen %min% und %max% Zeichen lang sein!');
            $stringLengthPassword = new StringLength();
            $stringLengthPassword->setMax(50)->setMin(4)->setEncoding('UTF-8');
            $stringLengthPassword->setMessage('Password muss zwischen %min% und %max% Zeichen lang sein!');

            $username = new Input('username');
            $username->getFilterChain()->attachByName(StripTags::class)->attachByName(StringTrim::class);
            $username->getValidatorChain()->attach($notEmpty, true)->attach($stringLengthUsername);



            $password = new Input('password');
            $password->getFilterChain()->attachByName(StripTags::class)->attachByName(StringTrim::class);
            $password->getValidatorChain()->attach($notEmpty, true)->attach($stringLengthPassword);


            $inputFilter->add($username)->add($password);




            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }
}