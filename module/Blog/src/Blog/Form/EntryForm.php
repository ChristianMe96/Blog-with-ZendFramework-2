<?php

namespace Blog\Form;


use Zend\Form\Element;
use Zend\Form\Fieldset;
use Zend\Form\Form;

class EntryForm extends Form
{
    public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct('entry');

        /*
        $dateInputHidden = new Element\Hidden();
        $dateInputHidden->setName('date');
        $dateInputHidden->setValue(date("Y-m-d H:i:s"));
        */

        //ToDo: Fieldset benutzen

        $titleInput = new Element\Text();
        $titleInput->setName('title');
        $titleInput->setLabel('Title');
        $titleInput->setAttribute('class','form-control');

        $contentInput = new Element\Text();
        $contentInput->setName('content');
        $contentInput->setLabel('Content');
        $contentInput->setAttribute('class','form-control');
        /*
        $authorInput = new Element\Hidden();
        $authorInput->setName('authorId');
        $authorInput->setAttribute('class','form-control');
        */
        $submit = new Element\Submit();
        $submit->setName('submit');
        $submit->setAttributes([
            'value' => 'Add',
            'id' => 'submitbutton',
            'class' => 'btn  btn-default',
        ]);

        $this->add($titleInput)->add($contentInput)->add($submit);

    }
}