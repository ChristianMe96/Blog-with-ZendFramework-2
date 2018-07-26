<?php

namespace Blog\View\Helper;


use Blog\Entity\Entry;
use Blog\Entity\Tag;
use Doctrine\ORM\EntityManager;
use Zend\View\Helper\AbstractHelper;

class TagCloud extends AbstractHelper
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    public function getTagCloud()
    {
        $tagCloud = [];

        $posts = $this->entityManager->getRepository(Entry::class)->findEntriesWithTags()->getResult();
        $totalEntryCount = count($posts);

        $tags = $this->entityManager->getRepository(Tag::class)
            ->findAll();

        /** @var Tag $tag */
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
            $normalizedTagCloud[$name] =  $postCount/$totalEntryCount;
        }

        return $normalizedTagCloud;
    }

}