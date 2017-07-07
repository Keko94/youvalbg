<?php

namespace Discutea\DForumBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Discutea\DForumBundle\Entity\Model\BaseForum;

/**
 * @ORM\Entity(repositoryClass="Discutea\DForumBundle\Repository\ForumRepository")
 * @ORM\Table(name="df_forum")
 * @ODM\Document(repositoryClass="Discutea\DForumBundle\Repository\ForumRepositoryODM", collection="df_forum")
 */
class Forum extends BaseForum
{

}
