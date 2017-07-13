<?php

namespace Tyras\UserBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use FOS\UserBundle\Model\User as BaseUser;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="Tyras\UserBundle\Repository\UserRepository")
 * @ORM\HasLifecycleCallbacks
 * @ODM\Document(repositoryClass="Tyras\UserBundle\Repository\UserRepositoryODB", collection="users")
 * @ODM\HasLifecycleCallbacks
 */
class User extends BaseUser implements \Hackzilla\Bundle\TicketBundle\Model\UserInterface
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ODM\Id(strategy="CUSTOM", type="int", options={"class"="Tyras\UserBundle\Generator\Generator"})
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="facebook_id", type="string", nullable=true)
     * @ODM\Field(type="string")
     */
    protected $facebook_id;

    /**
     * @var string
     *
     * @ORM\Column(name="facebook_access_token", type="string", length=255, nullable=true)
     * @ODM\Field(type="string")
     */
    protected $facebook_access_token;

    /**
     * @var string
     *
     * @ORM\Column(name="google_id", type="string", nullable=true)
     * @ODM\Field(type="string")
     */
    protected $google_id;

    /**
     * @var string
     *
     * @ORM\Column(name="google_access_token", type="string", length=255, nullable=true)
     * @ODM\Field(type="string")
     */
    protected $google_access_token;

    /**
     * @var string
     *
     * @ORM\Column(name="twitter_id", type="string", nullable=true)
     * @ODM\Field(type="string")
     */
    protected $twitter_id;

    /**
     * @var string
     *
     * @ORM\Column(name="twitter_access_token", type="string", length=255, nullable=true)
     * @ODM\Field(type="string")
     */
    protected $twitter_access_token;


    /**
     *  @var string
     *
     * @ORM\Column(name="avatar", type="string", length=255, nullable=true)
     * @ODM\Field(type="string")
     */
    protected $avatar;

    /**
     * @var UploadedFile
     *
     * @Assert\File(
     *     maxSize = "5M",
     *     mimeTypes = {"image/jpeg", "image/gif", "image/png", "image/tiff"},
     *     maxSizeMessage = "The maxmimum allowed file size is 5MB.",
     *     mimeTypesMessage = "Only the filetypes image are allowed.")
     */
    protected $avatar_file;

    protected $avatarTemp;

    protected $avatar_name;

    protected $token;


    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Set facebookId
     *
     * @param string $facebookId
     *
     * @return User
     */
    public function setFacebookId($facebookId)
    {
        $this->facebook_id = $facebookId;

        return $this;
    }

    /**
     * Get facebookId
     *
     * @return string
     */
    public function getFacebookId()
    {
        return $this->facebook_id;
    }

    /**
     * Set googleId
     *
     * @param string $googleId
     *
     * @return User
     */
    public function setGoogleId($googleId)
    {
        $this->google_id = $googleId;

        return $this;
    }

    /**
     * Get googleId
     *
     * @return string
     */
    public function getGoogleId()
    {
        return $this->google_id;
    }

    /**
     * Set twitterId
     *
     * @param string $twitterId
     *
     * @return User
     */
    public function setTwitterId($twitterId)
    {
        $this->twitter_id = $twitterId;

        return $this;
    }

    /**
     * Get twitterId
     *
     * @return string
     */
    public function getTwitterId()
    {
        return $this->twitter_id;
    }

    /**
     * Get facebookAccessToken
     *
     * @return string
     */
    public function getFacebookAccessToken()
    {
        return $this->facebook_access_token;
    }

    /**
     * Set facebookAccessToken
     *
     * @param string $facebookAccessToken
     *
     * @return User
     */
    public function setFacebookAccessToken($facebookAccessToken)
    {
        $this->facebook_access_token = $facebookAccessToken;

        return $this;
    }

    /**
     * Get googleAccessToken
     *
     * @return string
     */
    public function getGoogleAccessToken()
    {
        return $this->google_access_token;
    }

    /**
     * Set googleAccessToken
     *
     * @param string $googleAccessToken
     *
     * @return User
     */
    public function setGoogleAccessToken($googleAccessToken)
    {
        $this->google_access_token = $googleAccessToken;

        return $this;
    }

    /**
     * Get twitterAccessToken
     *
     * @return string
     */
    public function getTwitterAccessToken()
    {
        return $this->twitter_access_token;
    }

    /**
     * Set twitterAccessToken
     *
     * @param string $twitterAccessToken
     *
     * @return User
     */
    public function setTwitterAccessToken($twitterAccessToken)
    {
        $this->twitter_access_token = $twitterAccessToken;

        return $this;
    }

    /**
     * @return string
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * @param $avatar
     * @return User
     */
    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;

        return $this;
    }

    public function getAvatarFile()
    {
        return $this->avatar_file;
    }

    /**
     * Sets avatar.
     *
     * @param UploadedFile $avatar_file
     */
    public function setAvatarFile(UploadedFile $avatar_file = null)
    {
        $this->avatar_file = $avatar_file;
        // check if we have an old image path
        if (isset($this->avatar)) {
            // store the old name to delete after the update
            $this->avatarTemp = $this->avatar;
            $this->avatar = null;
        } else {
            $this->avatar = 'initial';
        }
    }

    public function getAbsolutePath()
    {
        return null === $this->avatar
            ? null
            : $this->getUploadRootDir().'/'.$this->avatar;
    }

    public function getWebPath()
    {
        return null === $this->avatar
            ? null
            : $this->getUploadDir().'/'.$this->avatar;
    }

    public function getUploadDir()
    {
        return 'uploads/user/avatar';
    }

    protected function getUploadRootDir()
    {
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }


    /**
     * @ORM\PostRemove()
     * @ODM\PostRemove()
     */
    public function removeUpload()
    {
        /*$file = $this->getAbsolutePath();
        if ($file) {
            @unlink($file);
        }*/
        @unlink($this->avatar);
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     * @ODM\PrePersist()
     * @ODM\PreUpdate()
     */
    public function preUpload()
    {
        if (null !== $this->avatar_file) {
            $filename = sha1(uniqid(mt_rand(), true));
            $this->avatar_name = $filename.'.'.$this->getAvatarFile()->guessExtension();
            //ATTENTION LIEN HARDCODED!!!
            $this->avatar = '/Tyras-Mongo/web/'.$this->getUploadDir().'/'.$this->avatar_name;
        }
    }

    /**
     * Called after entity persistence
     *
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     * @ODM\PostPersist()
     * @ODM\PostUpdate()
     */
    public function upload()
    {
        // The file property can be empty if the field is not required
        if (null === $this->avatar_file) {
            return;
        }

        // check if we have an old image
        if (isset($this->avatarTemp)) {
            if (substr($this->avatarTemp, 0, 4) !== "http") {
                // delete the old image
                @unlink(/*$this->getUploadRootDir().'/'.*/$this->avatarTemp);
            }
            // clear the temp image path
            $this->avatarTemp = null;
        }

        $this->getAvatarFile()->move(
            $this->getUploadRootDir(),
            $this->avatar_name
        );

        // Clean up the file property as you won't need it anymore
        $this->avatar_file = null;
    }

    /**
     * @return mixed
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param mixed $token
     */
    public function setToken($token)
    {
        $this->token = $token;
    }


}

