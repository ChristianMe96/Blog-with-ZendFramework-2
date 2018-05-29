<?php

namespace Blog\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 *
 * @ORM\Entity
 *
 */

class User
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */

    protected $username;

    /**
     * @ORM\Column(type="string")
     */

    protected $password;

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return integer
     */
    public function getPassword()
    {
        return $this->password;
    }
    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }


    public function exchangeArray($data)
    {
        $this->id     = (!empty($data['id'])) ? $data['id'] : null;
        $this->username  = (!empty($data['username'])) ? $data['username'] : null;
        $this->password = (!empty($data['password'])) ? $data['password'] : null;
    }


}