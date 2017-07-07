<?php

namespace Discutea\DForumBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Discutea\DForumBundle\Entity\Model\BasePost;

/**
 * 
 * @ORM\Entity(repositoryClass="Discutea\DForumBundle\Repository\PostRepository")
 * @ORM\Table(name="df_post")
 * @ODM\Document(repositoryClass="Discutea\DForumBundle\Repository\PostRepositoryODM", collection="df_post")
 * 
 */
class Post extends BasePost
{

}
