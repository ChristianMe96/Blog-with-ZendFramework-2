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

            $stringLengthValidator = new StringLength();
            $stringLengthValidator->setMax(18)->setMin(1)->setEncoding('UTF-8');

            $username = new Input('username');
            $username->getFilterChain()->attachByName(StripTags::class)->attachByName(StringTrim::class);
            $username->getValidatorChain()->attach($stringLengthValidator);



            $password = new Input('password');
            $password->getFilterChain()->attachByName(StripTags::class)->attachByName(StringTrim::class);
            $password->getValidatorChain()->attach($stringLengthValidator);


            $inputFilter->add($username)->add($password);




            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }
}