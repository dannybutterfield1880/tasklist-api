<?php 

namespace Core\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="UserRepository")
 * @ORM\Table(name="users")
 */
class User extends Authenticatable {

    /**
     * @ORM\Column(type="string")
     */
    protected $username;

    /**
     * @ORM\Column(type="string")
     */
    protected $firstName;

    /**
     * @ORM\Column(type="string")
     */
    protected $lastName;

    /**
     * @ORM\Column(type="string")
     */
    protected $email;

    /**
     * @ORM\OneToMany(targetEntity="Core\Entity\Tasklist", mappedBy="creator")
     * @var Tasklist[] An ArrayCollection of Tasklist objects.
     */
    protected $createdTasklists;

    /**
     * @ORM\OneToMany(targetEntity="Core\Entity\Task", mappedBy="creator")
     * @var Task[] An ArrayCollection of Task objects.
     */
    protected $createdTasks;

    /**
     * @ORM\OneToMany(targetEntity="Core\Entity\Task", mappedBy="asignee")
     * @var Task[] An ArrayCollection of Task objects.
     */
    protected $assignedTasks;

    /**
     * @ORM\OneToMany(targetEntity="Core\Entity\Comment", mappedBy="creator")
     * @var Comment[] An ArrayCollection of Comment objects.
     */
    protected $commentsMade;

     /**
     * Constructor
     */
    public function __construct()
    {
        $this->createdTasklists = new \Doctrine\Common\Collections\ArrayCollection();
        $this->createdTasks = new \Doctrine\Common\Collections\ArrayCollection();
        $this->assignedTasks = new \Doctrine\Common\Collections\ArrayCollection();
        $this->commentsMade = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set username.
     *
     * @param string $username
     *
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username.
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set firstName.
     *
     * @param string $firstName
     *
     * @return User
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName.
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName.
     *
     * @param string $lastName
     *
     * @return User
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName.
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set email.
     *
     * @param string $email
     *
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email.
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set password.
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password.
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set lastSignOn.
     *
     * @param \DateTime|null $lastSignOn
     *
     * @return User
     */
    public function setLastSignOn($lastSignOn = null)
    {
        $this->lastSignOn = $lastSignOn;

        return $this;
    }

    /**
     * Get lastSignOn.
     *
     * @return \DateTime|null
     */
    public function getLastSignOn()
    {
        return $this->lastSignOn;
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
     * @return User
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
     * @return User
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
     * Add createdTasklist.
     *
     * @param \Core\Entity\Tasklist $createdTasklist
     *
     * @return User
     */
    public function addCreatedTasklist(\Core\Entity\Tasklist $createdTasklist)
    {
        $this->createdTasklists[] = $createdTasklist;

        return $this;
    }

    /**
     * Remove createdTasklist.
     *
     * @param \Core\Entity\Tasklist $createdTasklist
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeCreatedTasklist(\Core\Entity\Tasklist $createdTasklist)
    {
        return $this->createdTasklists->removeElement($createdTasklist);
    }

    /**
     * Get createdTasklists.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCreatedTasklists()
    {
        return $this->createdTasklists;
    }

    /**
     * Add createdTask.
     *
     * @param \Core\Entity\Task $createdTask
     *
     * @return User
     */
    public function addCreatedTask(\Core\Entity\Task $createdTask)
    {
        $this->createdTasks[] = $createdTask;

        return $this;
    }

    /**
     * Remove createdTask.
     *
     * @param \Core\Entity\Task $createdTask
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeCreatedTask(\Core\Entity\Task $createdTask)
    {
        return $this->createdTasks->removeElement($createdTask);
    }

    /**
     * Get createdTasks.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCreatedTasks()
    {
        return $this->createdTasks;
    }

    /**
     * Add assignedTask.
     *
     * @param \Core\Entity\Task $assignedTask
     *
     * @return User
     */
    public function addAssignedTask(\Core\Entity\Task $assignedTask)
    {
        $this->assignedTasks[] = $assignedTask;

        return $this;
    }

    /**
     * Remove assignedTask.
     *
     * @param \Core\Entity\Task $assignedTask
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeAssignedTask(\Core\Entity\Task $assignedTask)
    {
        return $this->assignedTasks->removeElement($assignedTask);
    }

    /**
     * Get assignedTasks.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAssignedTasks()
    {
        return $this->assignedTasks;
    }

    /**
     * Add commentsMade.
     *
     * @param \Core\Entity\Comment $commentsMade
     *
     * @return User
     */
    public function addCommentsMade(\Core\Entity\Comment $commentsMade)
    {
        $this->commentsMade[] = $commentsMade;

        return $this;
    }

    /**
     * Remove commentsMade.
     *
     * @param \Core\Entity\Comment $commentsMade
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeCommentsMade(\Core\Entity\Comment $commentsMade)
    {
        return $this->commentsMade->removeElement($commentsMade);
    }

    /**
     * Get commentsMade.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCommentsMade()
    {
        return $this->commentsMade;
    }
}