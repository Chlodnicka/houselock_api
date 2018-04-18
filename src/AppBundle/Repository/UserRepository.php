<?php
/**
 * Created by PhpStorm.
 * User: majac
 * Date: 28.03.2018
 * Time: 14:35
 */

namespace AppBundle\Repository;

use AppBundle\Entity\Role;
use AppBundle\Entity\User;
use AppBundle\Entity\UserStatus;
use Doctrine\ORM\EntityManagerInterface;

class UserRepository extends Repository
{
    /**
     * @var \Doctrine\Common\Persistence\ObjectRepository
     */
    protected $repository;

    /**
     * FlatRepository constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager);
        $this->repository = $this->entityManager->getRepository(User::class);
    }

    /**
     * @return array
     */
    public function getAll()
    {
        return $this->repository->findAll();
    }

    /**
     * @param int $id
     * @return User|null
     */
    public function get(int $id)
    {
        return $this->repository->find($id);
    }

    /**
     * @param array $criteria
     * @return array
     */
    public function getByCriteria(array $criteria)
    {
        return $this->repository->findBy($criteria);
    }

    /**
     * @param array $criteria
     * @return User|null
     */
    public function getOneByCriteria(array $criteria)
    {
        return $this->repository->findOneBy($criteria);
    }

    /**
     * @param User $user
     */
    public function registerUser(User $user, Role $role)
    {
        $this->entityManager->persist($user);
        $this->entityManager->persist($role);
        $this->entityManager->flush();
    }

    /**
     * @param User $user
     * @param array $data
     * @return User
     */
    public function updateUser(User $user, array $data)
    {
        $user->setUpdatedBy($user->getId())
            ->setUpdatedAt(new \DateTime('now'))
            ->setEmail($data['email'])
            ->setFirstname($data['firstname'])
            ->setLastname($data['lastname'])
            ->setPhone($data['phone'])
            ->setUsername($data['username']);
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }

    public function setPassword(User $user, $password)
    {
        $user->setPassword($password);
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    /**
     * @param User $user
     * @param string $email
     * @param Role $role
     * @return User|array|null
     */
    public function createTenant(User $user, string $email, Role $role)
    {
        $tenant = new User();
        $activationCode = base64_encode(random_bytes(10));

        /**
         * @var $userStatus UserStatus
         */
        $userStatus = $this->entityManager->getRepository('Orm:UserStatus')->find(2);
        $tenant->setEmail($email)
            ->setUserStatus($userStatus)
            ->addRole($role)
            ->setCreatedBy($user->getId())
            ->setCreatedAt(new \DateTime('new'))
            ->setActivationToken($activationCode)
            ->setActivationGenerated(new \DateTime('now'));

        $this->entityManager->persist($tenant);
        $this->entityManager->flush();

        return $tenant;
    }
}