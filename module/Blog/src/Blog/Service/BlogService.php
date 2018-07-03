<?php

namespace Blog\Service;


use Blog\Entity\Comment;
use Blog\Entity\Entry;
use Blog\Entity\Tag;
use Blog\Entity\User;
use Blog\Exception\UsernameAlreadyExists;
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

    public function addNewEntry($data)
    {
        $container = new Container('login');
        // Create new Post entity.+

        $entry = new Entry();
        $entry->setTitle($data['title']);
        $entry->setContent($data['content']);
        $entry->setDate(date('Y-m-d H:i:s'));
        $entry = $this->addNewTags($data['tags'], $entry);

        $user = $this->entityManager->getRepository(User::class)->find($container->userId);
        $entry->setAuthor($user);

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
        //Exeption throwen

        if (!$this->entityManager->persist($user)) {
            throw new UsernameAlreadyExists();
        }
        $this->entityManager->persist($user);

        $this->entityManager->flush();
    }

    public function editEntry($data, $entry)
    {
        $container = new Container('login');
        $entry->setTitle($data['title']);
        $entry->setContent($data['content']);
        $entry->setDate(date('Y-m-d H:i:s'));
        $entry = $this->addNewTags($data['tags'], $entry);

        $user = $this->entityManager->getRepository(User::class)->find($container->userId);
        $entry->setAuthor($user);

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
        $comment->setEntry($entry);
        $comment->setComment($data['contentComment']);
        $comment->setDate(date('Y-m-d H:i:s'));
        $comment->setUrl($data['commentUrl']);
        $comment->setMail($data['commentMail']);

        // Add the entity to entity manager.
        $this->entityManager->persist($comment);

        // Apply changes to database.
        $this->entityManager->flush();

    }

    public function addNewTags($data,Entry $entry)
    {
        $splitString = explode(',' , $data);
        foreach ($splitString as $tag) {
            $newTag = new Tag();
            $newTag->setName($tag);

            $entry->addTag($newTag);
        }

        return $entry;
    }

    public function getTagCloud()
    {
        $tagCloud = [];

        $posts = $this->entityManager->getRepository(Entry::class)->findEntriesWithTags()->getResult();
        $totalPostCount = count($posts);

        $tags = $this->entityManager->getRepository(Tag::class)
            ->findAll();
        foreach ($tags as $tag) {

            $postsByTag = $this->entityManager->getRepository(Entry::class)
                ->findEntriesByTag($tag->getName())->getResult();

            $postCount = count($postsByTag);
            if ($postCount > 0) {
                $tagCloud[$tag->getName()] = $postCount;
            }
        }

        $normalizedTagCloud = [];

        // Normalize
        foreach ($tagCloud as $name=>$postCount) {
            $normalizedTagCloud[$name] =  $postCount/$totalPostCount;
        }

        return $normalizedTagCloud;
    }
}