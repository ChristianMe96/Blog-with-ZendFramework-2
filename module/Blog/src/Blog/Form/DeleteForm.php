<?php

namespace Blog\Form;


use Zend\Form\Element\Submit;
use Zend\Form\Form;

class DeleteForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('delete');

        $deleteYes = new Submit();
        $deleteYes->setName('deleteYes');
        $deleteYes->setAttributes([
            'value' => 'Yes',
            'id' => 'deleteYes',
            'class' => 'btn  btn-default',
        ]);

        $deleteNo = new Submit();
        $deleteNo->setName('deleteNo');
        $deleteNo->setAttributes([
            'value' => 'No',
            'id' => 'deleteNo',
            'class' => 'btn  btn-default',
        ]);

        $this->add($deleteYes)->add($deleteNo);

    }
}