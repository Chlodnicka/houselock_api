<?php
/**
 * Created by PhpStorm.
 * User: majac
 * Date: 28.03.2018
 * Time: 14:35
 */

namespace AppBundle\Repository;


use AppBundle\Entity\Bill;
use Doctrine\ORM\EntityManagerInterface;

class BillRepository extends Repository
{

    /**
     * @var \Doctrine\Common\Persistence\ObjectRepository
     */
    protected $repository;

    /**
     * BillRepository constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager);
        $this->repository = $this->entityManager->getRepository(Bill::class);
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
     * @return Bill|null
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