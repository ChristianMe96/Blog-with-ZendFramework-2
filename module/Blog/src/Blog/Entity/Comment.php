<?php
/**
 * Created by PhpStorm.
 * User: christian.meinhard
 * Date: 30.05.2018
 * Time: 14:33
 */

namespace Blog\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 *
 * @ORM\Entity(repositoryClass="Blog\Repository\Comment")
 *
 */

class Comment
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="Entry")
     * @ORM\JoinColumn(name="entryId", referencedColumnName="id")
     */
    private $entryId;

    /**
     * @ORM\Column(type="string")
     */
    private $comment;

    /**
     * @ORM\Column(type="string")
     */
    private $date;

    /**
     * @ORM\Column(type="string")
     */
    private $url;

    /**
     * @ORM\Column(type="string")
     */
    private $mail;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     * @return Comment
     */
    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEntryId()
    {
        return $this->entryId;
    }

    /**
     * @param mixed $entryId
     * @return Comment
     */
    public function setEntryId($entryId)
    {
        $this->entryId = $entryId;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @param mixed $comment
     * @return Comment
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     * @return Comment
     */
    public function setDate($date)
    {
        $this->date = $date;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param mixed $url
     * @return Comment
     */
    public function setUrl($url)
    {
        $this->url = $url;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * @param mixed $mail
     * @return Comment
     */
    public function setMail($mail)
    {
        $this->mail = $mail;
        return $this;
    }
}