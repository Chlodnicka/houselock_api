<?php
/**
 * Created by PhpStorm.
 * User: majac
 * Date: 28.03.2018
 * Time: 14:35
 */

namespace AppBundle\Repository;

use AppBundle\Entity\UserStatus;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class UserStatusRepository
 * @package AppBundle\Repository
 */
class UserStatusRepository extends Repository
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
        $this->repository = $this->entityManager->getRepository(UserStatus::class);
    }

    /**
     * @return array
     */
    public function getAll()
    {
        return $this->repository->findAll();
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
     * @return UserStatus|null
     */
    public function getTemp()
    {
        return $this->repository->find(2);
    }

    /**
     * @return UserStatus|null
     */
    public function getActive()
    {
        return $this->repository->find(1);
    }

    /**
     * @return UserStatus|null
     */
    public function getBlocked()
    {
        return $this->repository->find(3);
    }
}