<?php

namespace Discutea\DForumBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Discutea\DForumBundle\Entity\Model\BaseTopic;

/**
 *
 * @ORM\Entity(repositoryClass="Discutea\DForumBundle\Repository\TopicRepository")
 * @ORM\Table(name="df_topic")
 * @ODM\Document(repositoryClass="Discutea\DForumBundle\Repository\TopicRepositoryODM", collection="df_topic")
 * 
 */
class Topic extends BaseTopic
{

}
