<?php 

namespace Core\Model;

/**
 * @ORM\Entity
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
}