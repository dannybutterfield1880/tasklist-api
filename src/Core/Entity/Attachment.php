<?php

namespace Core\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * 
 * @ORM\Entity(repositoryClass="AttachmentRepository")
 * @ORM\Table("attachments")
 */
class Attachment extends Entity {
    
    /**
     * @ORM\Column(type="string")
     *
     * @var String $name
     */
    protected $name;

    /**
     * @ORM\Column(type="string")
     * 
     * @var String $extension
     */
    protected $extension;

    /**
     * @ORM\Column(type="string")
     *
     * @var String $thumbnailPath
     */
    protected $thumbnailPath;

    /**
     * @ORM\Column(type="string")
     * 
     * @var String $filePath
     */
    protected $filePath;

    /**
     * @ORM\ManyToOne(targetEntity="Core\Entity\Comment", inversedBy="attachments")
     *
     * @var Comment $commentAttachedTo
     */
    protected $commentAttachedTo;


    /**
     * @ORM\ManyToOne(targetEntity="Core\Entity\Task", inversedBy="attachments")
     *
     * @var Task $taskAttachedTo
     */
    protected $taskAttachedTo;
    
    
    /**
     * Set name.
     *
     * @param string $name
     *
     * @return Attachment
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set extension.
     *
     * @param string $extension
     *
     * @return Attachment
     */
    public function setExtension($extension)
    {
        $this->extension = $extension;

        return $this;
    }

    /**
     * Get extension.
     *
     * @return string
     */
    public function getExtension()
    {
        return $this->extension;
    }

    /**
     * Set thumbnailPath.
     *
     * @param string $thumbnailPath
     *
     * @return Attachment
     */
    public function setThumbnailPath($thumbnailPath)
    {
        $this->thumbnailPath = $thumbnailPath;

        return $this;
    }

    /**
     * Get thumbnailPath.
     *
     * @return string
     */
    public function getThumbnailPath()
    {
        return $this->thumbnailPath;
    }

    /**
     * Set filePath.
     *
     * @param string $filePath
     *
     * @return Attachment
     */
    public function setFilePath($filePath)
    {
        $this->filePath = $filePath;

        return $this;
    }

    /**
     * Get filePath.
     *
     * @return string
     */
    public function getFilePath()
    {
        return $this->filePath;
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set createdAt.
     *
     * @param \DateTime $createdAt
     *
     * @return Attachment
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt.
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt.
     *
     * @param \DateTime|null $updatedAt
     *
     * @return Attachment
     */
    public function setUpdatedAt($updatedAt = null)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt.
     *
     * @return \DateTime|null
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set commentAttachedTo.
     *
     * @param \Core\Entity\Comment|null $commentAttachedTo
     *
     * @return Attachment
     */
    public function setCommentAttachedTo(\Core\Entity\Comment $commentAttachedTo = null)
    {
        $this->commentAttachedTo = $commentAttachedTo;

        return $this;
    }

    /**
     * Get commentAttachedTo.
     *
     * @return \Core\Entity\Comment|null
     */
    public function getCommentAttachedTo()
    {
        return $this->commentAttachedTo;
    }

    /**
     * Set taskAttachedTo.
     *
     * @param \Core\Entity\Task|null $taskAttachedTo
     *
     * @return Attachment
     */
    public function setTaskAttachedTo(\Core\Entity\Task $taskAttachedTo = null)
    {
        $this->taskAttachedTo = $taskAttachedTo;

        return $this;
    }

    /**
     * Get taskAttachedTo.
     *
     * @return \Core\Entity\Task|null
     */
    public function getTaskAttachedTo()
    {
        return $this->taskAttachedTo;
    }
}