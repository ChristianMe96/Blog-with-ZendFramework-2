<?php
/**
 * Created by PhpStorm.
 * User: christian.meinhard
 * Date: 17.07.2018
 * Time: 15:56
 */

namespace Blog\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 *
 * @ORM\Entity(repositoryClass="Blog\Repository\Visitor")
 *
 */

class Visitor
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=15)
     */
    protected $ip;

    /**
     * @ORM\Column(type="string")
     */
    protected $date;

    /**
     * @return mixed
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * @param mixed $ip
     * @return Visitor
     */
    public function setIp($ip)
    {
        $this->ip = $ip;
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
     * @return Visitor
     */
    public function setDate($date)
    {
        $this->date = $date;
        return $this;
    }
}