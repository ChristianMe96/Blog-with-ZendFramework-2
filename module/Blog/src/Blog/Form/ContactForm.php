<?php

namespace Blog\Form;


use Zend\Form\Element\Email;
use Zend\Form\Element\Submit;
use Zend\Form\Element\Text;
use Zend\Form\Element\Textarea;
use Zend\Form\Form;

class ContactForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('email');

        $nameInput = new Text();
        $nameInput->setName('name');
        $nameInput->setLabel('Name');
        $nameInput->setAttributes([
                'class' => 'form-control',
                'placeholder' => 'Please enter your Name'
            ]
        );

        $mailInput = new Email();
        $mailInput->setName('email');
        $mailInput->setLabel('Email');
        $mailInput->setAttributes([
            'class' => 'form-control',
            'placeholder' => 'Please enter your email'
            ]
        );

        $messageInput = new Textarea();
        $messageInput->setName('message');
        $messageInput->setLabel('Message');
        $messageInput->setAttributes([
            'class' => 'form-control',
            'rows' => 10,
            'cols' => 60,
            'placeholder' => 'Write your Message here'
        ]);


        $submit = new Submit();
        $submit->setName('submit');
        $submit->setAttributes([
            'value' => 'Send Mail',
            'id' => 'submitMail',
            'class' => 'btn  btn-default',
        ]);

        $this->add($nameInput)->add($mailInput)->add($messageInput)->add($submit);

    }
}