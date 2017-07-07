<?php

namespace Discutea\DForumBundle\Repository;

class PostRepositoryODM extends \Doctrine\ODM\MongoDB\DocumentRepository
{
    /**
     * infos: Update LastPost on postPersist
     *
     * @param int $limit
     * @return array $lastPosts (List of last posts)
     */
    public function findLast($limit)
    {
        $lastPosts = $this->findBy(
            array(),
            array('date' => 'desc'),
            $limit,
            0
        );

        return $lastPosts;
    }

    /**
     * infos: Find lastEdited
     *
     * @param class Discutea\DForumBundle\Entity\Forum $forum
     * @return array $forumsList
     */
    public function findLastEdited($limit = null)
    {

        $qb = $this->createQueryBuilder('df_post');

        $qb->field('updated')->notEqual(null)
            ->sort("updated", 'DESC')
            ->limit($limit);
        return $qb->getQuery()->getResult();
    }

}
