<?php
namespace Discutea\DForumBundle\Repository;

use Discutea\DForumBundle\Entity\Forum;

class TopicRepositoryODM extends \Doctrine\ODM\MongoDB\DocumentRepository
{
    /**
     * infos: Find lastTopics list
     *
     * @param int $limit
     * @return array $lastTopics
     */
    public function findLast($limit)
    {
        $lastTopics = $this->findBy(
            array(),
            array('date' => 'desc'),
            $limit,
            0
        );

        return $lastTopics;
    }

    /**
     * infos: Find lastTopics list
     *
     * @param class Discutea\DForumBundle\Entity\Forum $forum
     * @return array $forumsList
     */
    public function findAllByForumOrderedByDate(Forum $forum, $order = 'DESC')
    {

        $qb = $this->createQueryBuilder('df_topic');

        $qb->field('forum')->equals($forum)
            //->join('t.posts', 'p')
            ->sort("pinned", 'DESC')
            ->sort("lastPost", $order);

        return $qb->getQuery()->getResult();
    }
}
