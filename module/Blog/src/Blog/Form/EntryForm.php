<?php

namespace Blog\Form;


use Zend\Form\Element;
use Zend\Form\Fieldset;
use Zend\Form\Form;

class EntryForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('entry');

        $titleInput = new Element\Text();
        $titleInput->setName('title');
        $titleInput->setLabel('Title');
        $titleInput->setAttribute('class','form-control');

        $contentInput = new Element\Textarea();
        $contentInput->setName('content');
        $contentInput->setLabel('Content');
        $contentInput->setAttributes([
            'class' => 'form-control',
            'rows' => 10,
            'cols' => 60
        ]);

        $tagsInput = new Element\Text();
        $tagsInput->setName('tags');
        $tagsInput->setLabel('Tags');
        $tagsInput->setAttributes([
            'class' => 'form-control',
            'placeholder' => 'comma, separated, list!!',
        ]);

        $submit = new Element\Submit();
        $submit->setName('submit');
        $submit->setAttributes([
            'value' => 'Add',
            'id' => 'submitbutton',
            'class' => 'btn  btn-default',
        ]);

        $this->add($titleInput)->add($contentInput)->add($tagsInput)->add($submit);

    }
}