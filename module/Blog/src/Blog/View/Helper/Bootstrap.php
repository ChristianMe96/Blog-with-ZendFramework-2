<?php

namespace Blog\View\Helper;


use Zend\View\Helper\AbstractHelper;

class Bootstrap extends AbstractHelper
{
    public function formGroupDiv($data)
    {
        return '<div class="form-group">'. $data .'</div>';
    }
}