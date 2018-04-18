<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * User
 *
 * @ORM\Table(name="user", uniqueConstraints={@ORM\UniqueConstraint(name="id_UNIQUE", columns={"id"})}, indexes={@ORM\Index(name="fk_user_user_status1_idx", columns={"user_status_id"})})
 * @ORM\Entity
 */
class User implements UserInterface, \Serializable
{
    /**
     * @var string
     *
     * @ORM\Column(name="firstname", type="string", length=255, nullable=true)
     */
    private $firstname;

    /**
     * @var string
     *
     * @ORM\Column(name="lastname", type="string", length=255, nullable=true)
     */
    private $lastname;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=12, nullable=true)
     */
    private $phone;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=false)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255, nullable=true)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="remember_token", type="string", length=255, nullable=true)
     */
    private $rememberToken;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    private $createdAt;

    /**
     * @var integer
     *
     * @ORM\Column(name="created_by", type="integer", nullable=false)
     */
    private $createdBy;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @var integer
     *
     * @ORM\Column(name="updated_by", type="integer", nullable=true)
     */
    private $updatedBy;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="deleted_at", type="datetime", nullable=true)
     */
    private $deletedAt;

    /**
     * @var integer
     *
     * @ORM\Column(name="deleted_by", type="integer", nullable=true)
     */
    private $deletedBy;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \AppBundle\Entity\UserStatus
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\UserStatus")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_status_id", referencedColumnName="id")
     * })
     */
    private $userStatus;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Role", mappedBy="user")
     */
    private $roles;


    /**
     * @ORM\Column(type="string", unique=true)
     */
    private $apiKey;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=255, nullable=true)
     */
    private $username;


    private $salt;


    /**
     * @Assert\NotBlank()
     * @Assert\Length(max=4096)
     */
    private $plainPassword;

    /**
     * @ORM\OneToMany(targetEntity="UserFlat", mappedBy="user")
     */
    private $userFlats;


    /**
     * @var string
     *
     * @ORM\Column(name="activation_token", type="string", length=255, nullable=true)
     */
    private $activationToken;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="activation_generated", type="datetime", nullable=true)
     */
    private $activationGenerated;

    private $activationLink;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->roles = new ArrayCollection();
        $this->userFlats = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * @param string $firstname
     * @return User
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
        return $this;
    }

    /**
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * @param string $lastname
     * @return User
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
        return $this;
    }

    /**
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     * @return User
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return string
     */
    public function getRememberToken()
    {
        return $this->rememberToken;
    }

    /**
     * @param string $rememberToken
     * @return User
     */
    public function setRememberToken($rememberToken)
    {
        $this->rememberToken = $rememberToken;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     * @return User
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return int
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * @param int $createdBy
     * @return User
     */
    public function setCreatedBy($createdBy)
    {
        $this->createdBy = $createdBy;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime $updatedAt
     * @return User
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    /**
     * @return int
     */
    public function getUpdatedBy()
    {
        return $this->updatedBy;
    }

    /**
     * @param int $updatedBy
     * @return User
     */
    public function setUpdatedBy($updatedBy)
    {
        $this->updatedBy = $updatedBy;
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
     * @return User
     */
    public function setDeletedAt($deletedAt)
    {
        $this->deletedAt = $deletedAt;
        return $this;
    }

    /**
     * @return int
     */
    public function getDeletedBy()
    {
        return $this->deletedBy;
    }

    /**
     * @param int $deletedBy
     * @return User
     */
    public function setDeletedBy($deletedBy)
    {
        $this->deletedBy = $deletedBy;
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
     * @return User
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return UserStatus
     */
    public function getUserStatus()
    {
        return $this->userStatus;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }


    /**
     * @param UserStatus $userStatus
     * @return User
     */
    public function setUserStatus($userStatus)
    {
        $this->userStatus = $userStatus;
        return $this;
    }


    public function getRoles()
    {
        $roles = [];
        foreach ($this->roles as $role) {
            $roles[] = $role->getName();
        }
        return $roles;
    }

    /**
     * @param Role $role
     * @return User
     */
    public function addRole(Role $role)
    {
        $this->roles[] = $role;
        return $this;
    }

    public function getUsername()
    {
        return $this->username;
    }


    public function getSalt()
    {
    }

    public function eraseCredentials()
    {
    }

    /**
     * @return mixed
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * @param mixed $plainPassword
     * @return User
     */
    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }

    /**
     * @param mixed $apiKey
     * @return User
     */
    public function setApiKey($apiKey)
    {
        $this->apiKey = $apiKey;
        return $this;
    }

    public function isEqualTo(UserInterface $user)
    {
        if (!$user instanceof User) {
            return false;
        }

        if ($this->password !== $user->getPassword()) {
            return false;
        }

        if ($this->salt !== $user->getSalt()) {
            return false;
        }

        if ($this->username !== $user->getUsername()) {
            return false;
        }

        return true;
    }

    /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
            // see section on salt below
            // $this->salt,
        ));
    }

    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password,
            // see section on salt below
            // $this->salt
            ) = unserialize($serialized);
    }

    /**
     * @return mixed
     */
    public function getUserFlats()
    {
        return $this->userFlats;
    }


    /**
     * @return Collection|null
     */
    public function getActiveUserFlats()
    {
        $usersFlat = $this->userFlats->filter(function (UserFlat $userFlat) {
            return $userFlat->getFlat()->getDeletedAt() === null;
        });

        if ($usersFlat) {
            return $usersFlat;
        }
        return null;
    }

    /**
     * @param UserFlat $userFlat
     * @return User
     */
    public function addUserFlats($userFlat)
    {
        $this->userFlats[] = $userFlat;
        return $this;
    }

    /**
     * @return string
     */
    public function getActivationToken(): string
    {
        return $this->activationToken;
    }

    /**
     * @param string $activationToken
     * @return User
     */
    public function setActivationToken(string $activationToken): User
    {
        $this->activationToken = $activationToken;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getActivationGenerated(): \DateTime
    {
        return $this->activationGenerated;
    }

    /**
     * @param \DateTime $activationGenerated
     * @return User
     */
    public function setActivationGenerated(\DateTime $activationGenerated): User
    {
        $this->activationGenerated = $activationGenerated;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getActivationLink()
    {
        return $this->activationLink;
    }

    /**
     * @param mixed $activationLink
     * @return User
     */
    public function setActivationLink($activationLink)
    {
        $this->activationLink = $activationLink;
        return $this;
    }

}

