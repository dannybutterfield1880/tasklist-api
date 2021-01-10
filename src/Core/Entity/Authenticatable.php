<?php 

namespace Core\Model;

/**
 * Authentication related entity (model) methods and props
 */
class Authenticatable extends Entity {

    /**
     * @ORM\Column(type="string")
     */
    protected $password;

    /**
     * @ORM\Column(type="string")
     */
    protected $salt;

    /**
     * @var \DateTime $created_at
     *
     * @ORM\Column(type="datetime")
     */
    protected $lastSignOn;
}