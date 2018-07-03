<?php
/**
 * Created by PhpStorm.
 * User: christian.meinhard
 * Date: 20.06.2018
 * Time: 15:34
 */

namespace Blog\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 *
 * @ORM\Entity(repositoryClass="Blog\Repository\Tag")
 *
 */
class Tag
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;


    /**
     * @ORM\Column(name="name")
     */
    protected $name;

    /**
     * Many Tags have Many Entries.
     * @ORM\ManyToMany(targetEntity="Entry", mappedBy="tags",cascade={"persist"})
     */
    protected $entries;

    public function addEntry(Entry $entry)
    {
        $this->entries[] = $entry;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }


}