<?php
/**
 * Created by PhpStorm.
 * User: christian.meinhard
 * Date: 05.06.2018
 * Time: 11:17
 */

namespace Blog\Form;


use Zend\Form\Element\Submit;
use Zend\Form\Element\Text;
use Zend\Form\Element\Textarea;
use Zend\Form\Form;

class AddCommentForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('addComment');


        $nameInput = new Text();
        $nameInput->setName('nameInput');
        $nameInput->setAttributes([
            'placeholder' => 'Username',
            'class' => 'form-control',
        ]);

        $commentMail = new Text();
        $commentMail->setName('commentMail');
        $commentMail->setAttributes([
            'placeholder' => 'E-Mail',
            'class' => 'form-control',
        ]);

        $commentUrl = new Text();
        $commentUrl->setName('commentUrl');
        $commentUrl->setAttributes([
            'placeholder' => 'URL',
            'class' => 'form-control',
        ]);

        $areaAddComment = new Textarea();
        $areaAddComment->setName('contentComment');
        $areaAddComment->setAttributes([
            'placeholder' => 'Comment',
            'class' => 'form-control',
            'rows' => 4,
        ]);

        $addComment = new Submit();
        $addComment->setName('addComment');
        $addComment->setAttributes([
            'value' => 'Submit',
            'id' => 'addComment',
            'class' => 'btn  btn-primary',
        ]);



        $this->add($nameInput)->add($commentMail)->add($commentUrl)->add($areaAddComment)->add($addComment);

    }
}