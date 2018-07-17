<?php
/**
 * Created by PhpStorm.
 * User: christian.meinhard
 * Date: 11.07.2018
 * Time: 13:40
 */

namespace Blog\Validator;


use Zend\Validator\AbstractValidator;

class Tag extends AbstractValidator
{
    const COMMA_END_START = 'commaEndStart';
    #const LOWERCASE = 'lowerCase';

    protected $messageTemplates = [
        self::COMMA_END_START => 'Tag liste darf nicht mit einem Komma enden oder anfangen',
        #self::LOWERCASE => 'Tags müssen alle klein geschrieben werden'
    ];

    public function isValid($value)
    {
        $this->setValue($value);

        $isValid = true;

        if ($this->startsWith($value,',') || $this->endsWith($value,',')){
            $this->error(self::COMMA_END_START);
            $isValid = false;
        }

        return $isValid;
    }

    private function startsWith($haystack, $needle)
    {
        $length = strlen($needle);
        return (substr($haystack, 0, $length) === $needle);
    }

    private function endsWith($haystack, $needle)
    {
        $length = strlen($needle);

        return $length === 0 ||
            (substr($haystack, -$length) === $needle);
    }
}