<?php
/**
 * Created by PhpStorm.
 * User: majac
 * Date: 28.03.2018
 * Time: 14:35
 */

namespace AppBundle\Repository;

use AppBundle\Entity\UserBill;
use Doctrine\ORM\EntityManagerInterface;

class UserBillRepository extends Repository
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
        $this->repository = $this->entityManager->getRepository(UserBill::class);
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
     * @return UserBill|null
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

}