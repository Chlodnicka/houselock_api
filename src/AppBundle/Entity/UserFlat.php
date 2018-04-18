<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserFlat
 *
 * @ORM\Table(name="user_flat", uniqueConstraints={@ORM\UniqueConstraint(name="id_UNIQUE", columns={"id"})}, indexes={@ORM\Index(name="fk_user_has_flat_flat1_idx", columns={"flat_id"}), @ORM\Index(name="fk_user_has_flat_user1_idx", columns={"user_id"}), @ORM\Index(name="fk_user_flat_role1_idx", columns={"role_id"})})
 * @ORM\Entity
 */
class UserFlat
{
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="deleted_at", type="datetime", nullable=true)
     */
    private $deletedAt;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \AppBundle\Entity\Role
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Role")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="role_id", referencedColumnName="id")
     * })
     */
    private $role;

    /**
     * @var \AppBundle\Entity\Flat
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Flat", inversedBy="userFlats")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="flat_id", referencedColumnName="id")
     * })
     */
    private $flat;

    /**
     * @var \AppBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="userFlats")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * })
     */
    private $user;

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     * @return UserFlat
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDeletedAt()
    {
        return $this->deletedAt;
    }

    /**
     * @param \DateTime $deletedAt
     * @return UserFlat
     */
    public function setDeletedAt($deletedAt)
    {
        $this->deletedAt = $deletedAt;
        return $this;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return UserFlat
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return Role
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @param Role $role
     * @return UserFlat
     */
    public function setRole($role)
    {
        $this->role = $role;
        return $this;
    }

    /**
     * @return Flat
     */
    public function getFlat()
    {
        return $this->flat;
    }

    /**
     * @param Flat $flat
     * @return UserFlat
     */
    public function setFlat($flat)
    {
        $this->flat = $flat;
        return $this;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     * @return UserFlat
     */
    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }



}

