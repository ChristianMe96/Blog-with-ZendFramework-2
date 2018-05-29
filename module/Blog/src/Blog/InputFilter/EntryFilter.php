<?php
/**
 * Created by PhpStorm.
 * User: christian.meinhard
 * Date: 24.05.2018
 * Time: 11:33
 */

namespace Blog\InputFilter;

use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Zend\Validator\StringLength;
use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\InputFilter\Input;
use Zend\InputFilter\InputFilter;



class EntryFilter implements InputFilterAwareInterface
{
    protected $inputFilter;

    // Add content to these methods:
    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used");
    }

    public function getInputFilter()
    {
        if (!$this->inputFilter) {



            $inputFilter = new InputFilter();

            $stringLengthValidator = new StringLength();
            $stringLengthValidator->setMax(1000)->setMin(1)->setEncoding('UTF-8');

            $title = new Input('title');
            $title->getFilterChain()->attachByName(StripTags::class)->attachByName(StringTrim::class);
            $title->getValidatorChain()->attach($stringLengthValidator);



            $content = new Input('content');
            $content->getFilterChain()->attachByName(StripTags::class)->attachByName(StringTrim::class);
            $content->getValidatorChain()->attach($stringLengthValidator);

            /*
            $author = new Input('authorId');
            $author->getFilterChain()->attachByName(StripTags::class)->attachByName(StringTrim::class);
            $author->getValidatorChain()->attach($stringLengthValidator);
            */

            $inputFilter->add($title)->add($content);#->add($author);




            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }
}