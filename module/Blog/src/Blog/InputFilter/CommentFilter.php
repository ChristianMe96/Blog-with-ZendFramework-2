<?php
/**
 * Created by PhpStorm.
 * User: christian.meinhard
 * Date: 05.06.2018
 * Time: 13:02
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

class CommentFilter implements InputFilterAwareInterface
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

            $commentLengthFilter = new StringLength();
            $commentLengthFilter->setMax(1000)->setMin(1)->setEncoding('UTF-8');
            $commentLengthFilter->setMessage('Kommentar muss zwischen %min% und %max% Zeichen lang sein!');

            $nameInputFilter = new StringLength();
            $nameInputFilter->setMax(15)->setMin(3)->setEncoding('UTF-8');
            $nameInputFilter ->setMessage('Name muss zwischen %min% und %max% Zeichen lang sein!');

            $urlMailLengthFilter = new StringLength();
            $urlMailLengthFilter->setMax(150)->setMin(0)->setEncoding('UTF-8');

            $nameInput = new Input('nameInput');
            $nameInput->getFilterChain()->attachByName(StripTags::class)->attachByName(StringTrim::class);
            $nameInput->getValidatorChain()->attach($notEmpty, true)->attach($nameInputFilter);

            $commentMail = new Input('commentMail');
            $commentMail->getFilterChain()->attachByName(StripTags::class)->attachByName(StringTrim::class);
            $commentMail->getValidatorChain()->attach($urlMailLengthFilter);
            $commentMail->setRequired(false);

            $commentUrl = new Input('commentUrl');
            $commentUrl->getFilterChain()->attachByName(StripTags::class)->attachByName(StringTrim::class);
            $commentUrl->getValidatorChain()->attach($urlMailLengthFilter);
            $commentUrl->setRequired(false);

            $content = new Input('contentComment');
            $content->getFilterChain()->attachByName(StripTags::class)->attachByName(StringTrim::class);
            $content->getValidatorChain()->attach($notEmpty, true)->attach($commentLengthFilter);


            $inputFilter->add($nameInput)->add($commentMail)->add($commentUrl)->add($content);




            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }

}