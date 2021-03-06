<?php

namespace Core\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\Ignore;


/**
 *
 * @ORM\Entity(repositoryClass="Core\Repository\TaskRepository")
 * @ORM\Table("tasks")
 */
class Task extends Entity {

    /**
     * @ORM\Column(type="string")
     * @Groups({"load_single_task_list"})
     * @var String $title
     */
    protected $title;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"load_single_task_list"})
     * @var String $description
     */
    protected $description;

    /**
     * @ORM\ManyToOne(targetEntity="Core\Entity\Tasklist", inversedBy="tasks")
     * @Ignore
     * @var Tasklist $tasklist
     */
    protected $tasklist;

    /**
     * @ORM\Column(type="string")
     *
     * options: low | medium | high | urgent | there-is-a-fire
     * @Groups({"load_single_task_list"})
     * @var String $priority
     */
    protected $priority = 'low';

    /**
     * @ORM\ManyToOne(targetEntity="Core\Entity\User", inversedBy="createdTasks")
     * @Groups({"load_single_task_list"})
     * @var User $user
     */
    protected $creator;

    /**
     * @ORM\ManyToOne(targetEntity="Core\Entity\User", inversedBy="assignedTasks")
     *
     * @var User $assignee
     */
    protected $assignee;

    /**
     * @ORM\OneToMany(targetEntity="Core\Entity\Comment", mappedBy="task")
     *
     * @var ArrayCollection|Comment[] $comments
     */
    protected $comments;

    /**
     * @ORM\Column(type="boolean")
     *
     * @var bool $flagged
     */
    protected $flagged = false;

    /**
     * @ORM\OneToMany(targetEntity="Core\Entity\Attachment", mappedBy="taskAttachedTo")
     *
     * @var ArrayCollection|Attachement[] $attachments
     */
    protected $attachments;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $completed = false;

    /**
     * @ORM\Column(type="integer", nullable=false)
     * @Groups({"load_single_task_list"})
     */
    protected $index = 0;


   /**
     * Constructor
     */
    public function __construct()
    {
        $this->comments = new \Doctrine\Common\Collections\ArrayCollection();
        $this->attachments = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set title.
     *
     * @param string $title
     *
     * @return Task
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description.
     *
     * @param string $description
     *
     * @return Task
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set priority.
     *
     * @param string $priority
     *
     * @return Task
     */
    public function setPriority($priority)
    {
        $this->priority = $priority;

        return $this;
    }

    /**
     * Get priority.
     *
     * @return string
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * Set flagged.
     *
     * @param bool $flagged
     *
     * @return Task
     */
    public function setFlagged($flagged)
    {
        $this->flagged = $flagged;

        return $this;
    }

    /**
     * Get flagged.
     *
     * @return bool
     */
    public function getFlagged()
    {
        return $this->flagged;
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
     * @return Task
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
     * @return Task
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
     * Set tasklist.
     *
     * @param \Core\Entity\Tasklist|null $tasklist
     *
     * @return Task
     */
    public function setTasklist(\Core\Entity\Tasklist $tasklist = null)
    {
        $this->tasklist = $tasklist;

        return $this;
    }

    /**
     * Get tasklist.
     *
     * @return \Core\Entity\Tasklist|null
     */
    public function getTasklist()
    {
        return $this->tasklist;
    }

    /**
     * Set creator.
     *
     * @param User|null $creator
     *
     * @return Task
     */
    public function setCreator(User $creator = null)
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
     * Set assignee.
     *
     * @param \Core\Entity\User|null $assignee
     *
     * @return Task
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
     * Add comment.
     *
     * @param \Core\Entity\Comment $comment
     *
     * @return Task
     */
    public function addComment(\Core\Entity\Comment $comment)
    {
        $this->comments[] = $comment;

        return $this;
    }

    /**
     * Remove comment.
     *
     * @param \Core\Entity\Comment $comment
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeComment(\Core\Entity\Comment $comment)
    {
        return $this->comments->removeElement($comment);
    }

    /**
     * Get comments.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Add attachment.
     *
     * @param \Core\Entity\Attachment $attachment
     *
     * @return Task
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

    /**
     * Set completed.
     *
     * @param bool $completed
     *
     * @return Task
     */
    public function setCompleted($completed)
    {
        $this->completed = $completed;

        return $this;
    }

    /**
     * Get completed.
     *
     * @return bool
     */
    public function getCompleted()
    {
        return $this->completed;
    }

    /**
     * Set index.
     *
     * @param int $index
     *
     * @return Task
     */
    public function setIndex($index)
    {
        $this->index = $index;
    
        return $this;
    }

    /**
     * Get index.
     *
     * @return int
     */
    public function getIndex()
    {
        return $this->index;
    }
}
