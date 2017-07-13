<?php

namespace Tyras\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Gedmo\Mapping\Annotation as Gedmo;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;

/**
 * Gallery
 *
 * @ORM\Table(name="gallery")
 * @ORM\Entity(repositoryClass="Tyras\CoreBundle\Repository\GalleryRepository")
 * @ODM\Document(repositoryClass="Tyras\CoreBundle\Repository\GalleryRepositoryODM", collection="gallery")
 * @Vich\Uploadable
 */
class Gallery
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ODM\Id(strategy="INCREMENT", type="int")
     */
    private $id;

    /**
     * @var File
     *
     * @Vich\UploadableField(mapping="image_gallery", fileNameProperty="name", size="size", mimeType="type")
     * @Assert\File(
     *  maxSize = "5M",
     *  mimeTypes = {"image/jpeg", "image/gif", "image/png", "image/tiff"},
     *  maxSizeMessage = "The maxmimum allowed file size is 5MB.",
     *  mimeTypesMessage = "Only the filetypes image are allowed.")
     */
    private $imageFile;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     * @ODM\Field(type="string")
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255)
     * @ODM\Field(type="string")
     */
    private $type;

    /**
     * @var int
     *
     * @ORM\Column(name="size", type="integer")
     * @ODM\Field(type="int")
     */
    private $size;

    /**
     * @var bool
     *
     * @ORM\Column(name="enabled", type="boolean")
     * @ODM\Field(type="boolean")
     */
    private $enabled = false;

    /**
     * @var \Tyras\UserBundle\Entity\User
     *
     * @ORM\OneToOne(targetEntity="\Tyras\UserBundle\Entity\User")
     * @ODM\ReferenceOne(targetDocument="\Tyras\UserBundle\Entity\User")
     */
    private $owner;

    /**
     * @ORM\OneToMany(targetEntity="\Tyras\UserBundle\Entity\User", mappedBy="id")
     * @ODM\ReferenceMany(targetDocument="\Tyras\UserBundle\Entity\User")
     */
    private $users_voted = array();

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     * @ODM\Field(type="date")
     */
    private $updatedAt;

    /**
     * @var string
     *
     * @ORM\Column(name="desc", type="string", length=255)
     * @ODM\Field(type="string")
     */
    private $desc;

    /**
     * @var float
     *
     * @ORM\Column(name="stars", type="float")
     * @ODM\Field(type="float")
     */
    private $stars = 0;

    /**
     * @var int
     */
    private $token;


    public function __construct()
    {
        $this->users_voted = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return File
     */
    public function getImageFile()
    {
        return $this->imageFile;
    }

    /**
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $imageFile
     */
    public function setImageFile(File $imageFile = null)
    {
        $this->imageFile = $imageFile;
        if ($imageFile) {
            $this->updatedAt = new \DateTime('now');
        }
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return int
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @param int $size
     */
    public function setSize($size)
    {
        $this->size = $size;
    }

    /**
     * @return bool
     */
    public function isEnabled()
    {
        return $this->enabled;
    }

    /**
     * @param bool $enabled
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;
    }

    /**
     * @return int
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param int $token
     */
    public function setToken($token)
    {
        $this->token = $token;
    }

    /**
     * @return mixed
     */
    public function getUsersVoted()
    {
        return $this->users_voted;
    }

    /**
     * @param mixed $users_voted
     */
    public function setUsersVoted($users_voted)
    {
        $this->users_voted = $users_voted;
    }

    public function addUsersVoted($user_voted)
    {
        $this->users_voted[] = $user_voted;
    }

    public function removeUsersVoted($user_voted)
    {
        $this->users_voted->removeElement($user_voted);
    }

    public function isUserVoted($user_voted)
    {
        return $this->users_voted->contains($user_voted);
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return string
     */
    public function getDesc()
    {
        return $this->desc;
    }

    /**
     * @param string $desc
     */
    public function setDesc($desc)
    {
        $this->desc = $desc;
    }

    /**
     * @return \Tyras\UserBundle\Entity\User
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * @param \Tyras\UserBundle\Entity\User $owner
     */
    public function setOwner($owner)
    {
        $this->owner = $owner;
    }

    /**
     * @return float
     */
    public function getStars()
    {
        return $this->stars;
    }

    /**
     * @param float $stars
     */
    public function setStars($stars)
    {
        $this->stars = $stars;
    }





}
