<?php

namespace Blog\Service;


use Blog\Entity\Comment;
use Blog\Entity\Entry;
use Blog\Entity\User;
use Doctrine\ORM\EntityManager;
use Zend\Session\Container;

class BlogService
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    //ToDo Fragen ob das mit dem Hinzufügen des ganzen Users so richtig ist

    public function addNewEntry($data)
    {
        $container = new Container('login');
        // Create new Post entity.
        $tags = explode(',' , $data['tags']);
        $entry = new Entry();
        $entry->setTitle($data['title']);
        $entry->setContent($data['content']);
        $entry->setDate(date('Y-m-d H:i:s'));
        $entry->setTags($tags);

        $user = $this->entityManager->find(User::class, $container->userId);
        $entry->setAuthorId($user);

        // Add the entity to entity manager.
        $this->entityManager->persist($entry);

        // Apply changes to database.
        $this->entityManager->flush();
    }

    public function addNewUser($data)
    {
        $user = new User();
        $user->setUsername($data['username']);
        //hash the Password
        $password = password_hash($data['password'], PASSWORD_BCRYPT,['cost' => 12]);
        $user->setPassword($password);


        $this->entityManager->persist($user);

        $this->entityManager->flush();
    }

    public function editEntry($data, $entry)
    {
        $container = new Container('login');
        $tags = explode(',' , $data['tags']);
        $entry->setTitle($data['title']);
        $entry->setContent($data['content']);
        $entry->setDate(date('Y-m-d H:i:s'));
        $entry->setTags($tags);

        $user = $this->entityManager->find(User::class, $container->userId);
        $entry->setAuthorId($user);

        $this->entityManager->flush();
    }

    public function deleteEntry($entry)
    {
        $this->entityManager->remove($entry);
        $this->entityManager->flush();
    }

    public function addNewComment($data, $entry)
    {
        $comment = new Comment();
        $comment->setUser($data['nameInput']);
        $comment->setEntryId($entry);
        $comment->setComment($data['contentComment']);
        $comment->setDate(date('Y-m-d H:i:s'));
        $comment->setUrl($data['commentUrl']);
        $comment->setMail($data['commentMail']);

        // Add the entity to entity manager.
        $this->entityManager->persist($comment);

        // Apply changes to database.
        $this->entityManager->flush();

    }

}