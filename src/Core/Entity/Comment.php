<?php

namespace Core\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;


/**
 * 
 * @ORM\Entity(repositoryClass="CommentRepository")
 * @ORM\Table("comments")
 */
class Comment extends Entity {

    /**
     * @ORM\Column(type="string")
     *
     * @var String $message
     */
    protected $message;

    /**
     * @ORM\ManyToOne(targetEntity="Core\Entity\Task", inversedBy="comments")
     * 
     * @var Task $task
     */
    protected $task;

    /**
     * @ORM\ManyToOne(targetEntity="Core\Entity\User", inversedBy="commentsMade")
     *
     * @var User $creator
     */
    protected $creator;

     // ...
    /**
     * One Comment will have many replies.
     * @ORM\OneToMany(targetEntity="Core\Entity\Comment", mappedBy="replyRespondant")
     * 
     * @var ArrayCollection|Comment[] $replies
     */
    protected $replies;

    /**
     * Many replies will have one respondant
     * @ORM\ManyToOne(targetEntity="Core\Entity\Comment", inversedBy="replies")
     * @ORM\JoinColumn(name="respondantId", referencedColumnName="id")
     * 
     * @var Comment $replyRespondant 
     */
    protected $replyRespondant;

    /**
     * @ORM\ManyToOne(targetEntity="Core\Entity\User", inversedBy="assignedTasks")
     *
     * @var User $user
     */
    protected $assignee;

    /**
     * @ORM\Column(type="boolean")
     *
     * @var bool $liked
     */
    protected $liked;

    /**
     * @ORM\OneToMany(targetEntity="Core\Entity\Attachment", mappedBy="commentAttachedTo")
     *
     * @var ArrayCollection|Attachment[] $attachments
     */
    protected $attachments;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->replies = new \Doctrine\Common\Collections\ArrayCollection();
        $this->attachments = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set message.
     *
     * @param string $message
     *
     * @return Comment
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message.
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set liked.
     *
     * @param bool $liked
     *
     * @return Comment
     */
    public function setLiked($liked)
    {
        $this->liked = $liked;

        return $this;
    }

    /**
     * Get liked.
     *
     * @return bool
     */
    public function getLiked()
    {
        return $this->liked;
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
     * @return Comment
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
     * @return Comment
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
     * Set task.
     *
     * @param \Core\Entity\Task|null $task
     *
     * @return Comment
     */
    public function setTask(\Core\Entity\Task $task = null)
    {
        $this->task = $task;

        return $this;
    }

    /**
     * Get task.
     *
     * @return \Core\Entity\Task|null
     */
    public function getTask()
    {
        return $this->task;
    }

    /**
     * Set creator.
     *
     * @param \Core\Entity\User|null $creator
     *
     * @return Comment
     */
    public function setCreator(\Core\Entity\User $creator = null)
    {
        $this->creator = $creator;

        return $this;
    }

    /**
     * Get creator.
     *
     * @return \Core\Entity\User|null
     */
    public function getCreator()
    {
        return $this->creator;
    }

    /**
     * Add reply.
     *
     * @param \Core\Entity\Comment $reply
     *
     * @return Comment
     */
    public function addReply(\Core\Entity\Comment $reply)
    {
        $this->replies[] = $reply;

        return $this;
    }

    /**
     * Remove reply.
     *
     * @param \Core\Entity\Comment $reply
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeReply(\Core\Entity\Comment $reply)
    {
        return $this->replies->removeElement($reply);
    }

    /**
     * Get replies.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getReplies()
    {
        return $this->replies;
    }

    /**
     * Set replyRespondant.
     *
     * @param \Core\Entity\Comment|null $replyRespondant
     *
     * @return Comment
     */
    public function setReplyRespondant(\Core\Entity\Comment $replyRespondant = null)
    {
        $this->replyRespondant = $replyRespondant;

        return $this;
    }

    /**
     * Get replyRespondant.
     *
     * @return \Core\Entity\Comment|null
     */
    public function getReplyRespondant()
    {
        return $this->replyRespondant;
    }

    /**
     * Set assignee.
     *
     * @param \Core\Entity\User|null $assignee
     *
     * @return Comment
     */
    public function setAssignee(\Core\Entity\User $assignee = null)
    {
        $this->assignee = $assignee;

        return $this;
    }

    /**
     * Get assignee.
     *
     * @return \Core\Entity\User|null
     */
    public function getAssignee()
    {
        return $this->assignee;
    }

    /**
     * Add attachment.
     *
     * @param \Core\Entity\Attachment $attachment
     *
     * @return Comment
     */
    public function addAttachment(\Core\Entity\Attachment $attachment)
    {
        $this->attachments[] = $attachment;

        return $this;
    }

    /**
     * Remove attachment.
     *
     * @param \Core\Entity\Attachment $attachment
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeAttachment(\Core\Entity\Attachment $attachment)
    {
        return $this->attachments->removeElement($attachment);
    }

    /**
     * Get attachments.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAttachments()
    {
        return $this->attachments;
    }
}