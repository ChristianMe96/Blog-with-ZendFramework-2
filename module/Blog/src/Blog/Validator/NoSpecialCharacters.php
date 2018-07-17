<?php
/**
 * Created by PhpStorm.
 * User: christian.meinhard
 * Date: 17.07.2018
 * Time: 09:18
 */

namespace Blog\Validator;


use Zend\Validator\AbstractValidator;

class NoSpecialCharacters extends AbstractValidator
{
    const NO_SPECIAL_CHARACTERS = 'noSpecialCharacters';

    protected $messageTemplates = [
        self::NO_SPECIAL_CHARACTERS => 'Tags dürfen nicht aus Sonderzeichen bestehen!',
    ];

    public function isValid($value)
    {
       $isValid = true;

       if (preg_match("/[^a-zA-Z,\,]/", $value)) {
           $this->error(self::NO_SPECIAL_CHARACTERS);
           $isValid = false;
       }

       return $isValid;
    }
}