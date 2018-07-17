<?php
/**
 * Created by PhpStorm.
 * User: christian.meinhard
 * Date: 16.07.2018
 * Time: 15:40
 */

namespace Blog\Filter;


use Zend\Filter\FilterInterface;

class NumbersSpecialCharactersExceptComma implements FilterInterface
{
    public function filter($value)
    {

        $valueFiltered = preg_replace("/[^a-zA-Z,\,]/gm", "", $value);

        return $valueFiltered;
    }
}