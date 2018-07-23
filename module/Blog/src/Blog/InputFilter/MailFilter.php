<?php
/**
 * Created by PhpStorm.
 * User: christian.meinhard
 * Date: 20.07.2018
 * Time: 09:36
 */

namespace Blog\InputFilter;


use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\InputFilter\Input;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Zend\Validator\EmailAddress;
use Zend\Validator\NotEmpty;
use Zend\Validator\StringLength;

class MailFilter implements InputFilterAwareInterface
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

            $stringLengthName= new StringLength();
            $stringLengthName->setMax(50)->setMin(5)->setEncoding('UTF-8');
            $stringLengthName->setMessage('Titel muss zwischen %min% und %max% Zeichen lang sein!');

            $stringLengthmessage = new StringLength();
            $stringLengthmessage ->setMax(1000)->setMin(15)->setEncoding('UTF-8');
            $stringLengthmessage ->setMessage('Text muss zwischen %min% und %max% Zeichen lang sein!');

            $name = new Input('name');
            $name->getFilterChain()->attachByName(StripTags::class)->attachByName(StringTrim::class);
            $name->getValidatorChain()->attach($notEmpty,true)->attach($stringLengthName);

            $email = new Input('email');
            $email->getFilterChain()->attachByName(StripTags::class)->attachByName(StringTrim::class);
            $email->getValidatorChain()->attach($notEmpty,true)->attach(new EmailAddress());

            $message = new Input('message');
            $message->getFilterChain()->attachByName(StripTags::class)->attachByName(StringTrim::class);
            $message->getValidatorChain()->attach($notEmpty,true)->attach($stringLengthmessage);


            $inputFilter->add($name)->add($email)->add($message);


            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }
}