<?php
/**
 * Created by PhpStorm.
 * User: majac
 * Date: 28.03.2018
 * Time: 14:35
 */

namespace AppBundle\Repository;

use AppBundle\Entity\Flat;
use AppBundle\Entity\Role;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class FlatRepository
 * @package AppBundle\Repository
 */
class RoleRepository extends Repository
{
    const ROLES = [
        'ROLE_ADMIN' => 1,
        'ROLE_MODERATOR' => 2,
        'ROLE_LANDLORD' => 3,
        'ROLE_TENANT' => 4,
    ];

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
        $this->repository = $this->entityManager->getRepository(Role::class);
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
     * @return Flat|null
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
     * @return Role|null
     */
    public function getLandlord()
    {
        return $this->repository->find(self::ROLES['ROLE_LANDLORD']);
    }

    /**
     * @return Role|null
     */
    public function getTenant()
    {
        return $this->repository->find(self::ROLES['ROLE_TENANT']);
    }
}