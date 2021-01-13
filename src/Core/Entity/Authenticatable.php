<?php

namespace Core\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Authentication related entity (model) methods and props
 */
class Authenticatable extends Entity {

    /**
     * @ORM\Column(type="string")
     */
    protected $password;

    /**
     * @var \DateTime $created_at
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $lastSignOn;

    /**
     * Set the value of password
     *
     * @return  self
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get $created_at
     *
     * @return  \DateTime
     */
    public function getLastSignOn()
    {
        return $this->lastSignOn;
    }

    /**
     * Set $created_at
     *
     * @param  \DateTime  $lastSignOn  $created_at
     *
     * @return  self
     */
    public function setLastSignOn(\DateTime $lastSignOn)
    {
        $this->lastSignOn = $lastSignOn;

        return $this;
    }

    static function hashPassword($plainPassword) {
      return password_hash($plainPassword, PASSWORD_BCRYPT);
    }

    public function verifyUsersPassword($plainPassword) {
        // Verify the hash against the password entered
        return password_verify($plainPassword, $this->password);
    }
}
