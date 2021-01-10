<?php

namespace Core\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="TasklistRepository")
 * @ORM\Table("tasklists")
 */
class Tasklist extends Entity {

    /**
     * @ORM\ManyToOne(targetEntity="Core\Entity\User", inversedBy="createdTasklists")
     * 
     * @var User $creator
     */
    protected $creator;

    /**
     * 
     * @ORM\Column(type="string")
     *
     * @var String $name
     */
    protected $name;

    /**
     * @ORM\OneToMany(targetEntity="Core\Entity\Task", mappedBy="tasklist")
     * @var ArrayCollection|Task[] An ArrayCollection of Task objects.
     */
    protected $tasks;
    
    //protected $userGroup;

   /**
     * Constructor
     */
    public function __construct()
    {
        $this->tasks = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return Tasklist
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
     * @return Tasklist
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
     * @return Tasklist
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
     * Set creator.
     *
     * @param \Core\Entity\User|null $creator
     *
     * @return Tasklist
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
     * Add task.
     *
     * @param \Core\Entity\Task $task
     *
     * @return Tasklist
     */
    public function addTask(\Core\Entity\Task $task)
    {
        $this->tasks[] = $task;

        return $this;
    }

    /**
     * Remove task.
     *
     * @param \Core\Entity\Task $task
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeTask(\Core\Entity\Task $task)
    {
        return $this->tasks->removeElement($task);
    }

    /**
     * Get tasks.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTasks()
    {
        return $this->tasks;
    }
}