<?php

namespace AppBundle\Entity;

use AppBundle\Model;

/**
 * Entity
 */
class Entity

{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

     /**
     * @var \DateTime $created_at
     *
     * @ORM\Column(type="datetime")
     */
    protected $created_at;

    /**
     * @var \DateTime $updated_at
     *
     * @ORM\Column(type="datetime")
     */
    protected $updated_at;
}