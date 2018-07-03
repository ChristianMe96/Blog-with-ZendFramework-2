<?php

namespace Blog\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 *
 * @ORM\Entity(repositoryClass="Blog\Repository\User")
 *
 */

class User
{

    //ToDo: relation zu Entry erstellen
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", unique=true)
     */

    protected $username;

    /**
     * @ORM\OneToMany(targetEntity="Entry", mappedBy="author")
     * @var Entry
     */
    protected $entries;

    /**
     * @return Entry
     */
    public function getEntries(): Entry
    {
        return $this->entries;
    }

    /**
     * @param Entry $entries
     */
    public function setEntries(Entry $entries): void
    {
        $this->entries = $entries;
    }

    /**
     * @param mixed $username
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }

    /**
     * @param mixed $password
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

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