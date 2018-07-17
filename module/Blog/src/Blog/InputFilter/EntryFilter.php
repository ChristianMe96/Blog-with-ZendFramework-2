<?php
/**
 * Created by PhpStorm.
 * User: christian.meinhard
 * Date: 24.05.2018
 * Time: 11:33
 */

namespace Blog\InputFilter;

use Blog\Filter\NumbersSpecialCharactersExceptComma;
use Blog\Validator\NoSpecialCharacters;
use Blog\Validator\Tag;
use Zend\Filter\File\UpperCase;
use Zend\Filter\PregReplace;
use Zend\Filter\StringToLower;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Zend\Validator\NotEmpty;
use Zend\Validator\Regex;
use Zend\Validator\StringLength;
use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\InputFilter\Input;
use Zend\InputFilter\InputFilter;



class EntryFilter implements InputFilterAwareInterface
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

            new UpperCase();

            $notEmpty = new NotEmpty();
            $notEmpty->setMessage('Darf nicht leer sein!');

            $specialCharcterFilter = new PregReplace([
                'pattern'     => '/bob/',
                'replacement' => 'john',
            ]);

            $stringLengthContent = new StringLength();
            $stringLengthContent->setMax(1000)->setMin(15)->setEncoding('UTF-8');
            $stringLengthContent->setMessage('Text muss zwischen %min% und %max% Zeichen lang sein!');
            $stringLengthTitle = new StringLength();
            $stringLengthTitle->setMax(64)->setMin(10)->setEncoding('UTF-8');
            $stringLengthTitle->setMessage('Titel muss zwischen %min% und %max% Zeichen lang sein!');

            $tagValidator = new Tag();
            $noSpecialCharacters = new NoSpecialCharacters();

            $title = new Input('title');
            $title->getFilterChain()->attachByName(StripTags::class)->attachByName(StringTrim::class);
            $title->getValidatorChain()->attach($notEmpty, true)->attach($stringLengthTitle);



            $content = new Input('content');
            $content->getFilterChain()->attachByName(StripTags::class)->attachByName(StringTrim::class);
            $content->getValidatorChain()->attach($notEmpty, true)->attach($stringLengthContent);


            $tags = new Input('tags');
            $tags->getFilterChain()->attachByName(StripTags::class)->attachByName(StringTrim::class)->attachByName(StringToLower::class);
            $tags->getValidatorChain()->attach($notEmpty, true)->attach($tagValidator, true)->attach($noSpecialCharacters, true);

            $inputFilter->add($title)->add($content)->add($tags);




            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }
}