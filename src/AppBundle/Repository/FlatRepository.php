<?php
/**
 * Created by PhpStorm.
 * User: majac
 * Date: 28.03.2018
 * Time: 14:35
 */

namespace AppBundle\Repository;

use AppBundle\Entity\Flat;
use AppBundle\Entity\FlatGasConfig;
use AppBundle\Entity\FlatMeter;
use AppBundle\Entity\FlatPowerConfig;
use AppBundle\Entity\FlatRentConfig;
use AppBundle\Entity\FlatWasteWaterConfig;
use AppBundle\Entity\FlatWaterConfig;
use AppBundle\Entity\Role;
use AppBundle\Entity\User;
use AppBundle\Entity\UserFlat;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class FlatRepository
 * @package AppBundle\Repository
 */
class FlatRepository extends Repository
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
        $this->repository = $this->entityManager->getRepository(Flat::class);
    }

    /**
     * @return array
     */
    public function getAll()
    {
        return $this->repository->findBy(['deletedAt' => NULL]);
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


    public function createFlat(User $user, array $data)
    {
        $flat = new Flat();
        $flat->setCreatedBy($user->getId())
            ->setCreatedAt(new \DateTime('now'));
        $flat = $this->setAddress($flat, $data);


        $this->entityManager->persist($flat);
        $this->entityManager->flush();

        $this->createUserFlat($user, $flat);
        $this->createFlatConfig($user, $flat, $data);
        $this->createFlatPrices($flat, $data);

        $this->entityManager->flush();
        $this->entityManager->refresh($flat);

        return $flat;
    }

    public function updateFlat(User $user, Flat $flat, array $data)
    {
        $flat = $this->setAddress($flat, $data);
        $flat->setUpdatedAt(new \DateTime('now'))
            ->setUpdatedBy($user->getId());

        $this->entityManager->persist($flat);

        $flatMeter = $this->setFlatConfig($flat->getFlatMeter(), $data);
        $this->entityManager->persist($flatMeter);

        //update prices
    }

    public function setAddress(Flat $flat, array $data)
    {
        $flat->setBuildingNumber($data['building_number'])
            ->setCity($data['city'])
            ->setFlatNumber($data['flat_number'])
            ->setName($data['name'])
            ->setPostalCode($data['postal_code'])
            ->setStreet($data['street']);
        return $flat;
    }

    public function createUserFlat(User $user, Flat $flat)
    {
        //fix
        $role = $this->entityManager->getRepository('Orm:Role')->find(3);

        $userFlat = new UserFlat();
        $userFlat->setCreatedAt(new \DateTime('now'))
            ->setRole($role)
            ->setFlat($flat)
            ->setUser($user);

        $this->entityManager->persist($userFlat);
    }

    public function createFlatConfig(User $user, Flat $flat, array $data)
    {
        if ($data['flat_meters']) {
            $flatMeter = new FlatMeter();
            $flatMeter->setFlat($flat);
            $flatMeter->setCreatedAt(new \DateTime('now'))
                ->setCreatedBy($user->getId());

            $flatMeter = $this->setFlatConfig($flatMeter, $data);
            $this->entityManager->persist($flatMeter);
        }
    }

    public function setFlatConfig(FlatMeter $flatMeter, array $data)
    {
        $flatMeter->setGasMeter($data['gas_meter'])
            ->setPowerMeter($data['power_meter'])
            ->setWasteWaterMeter($data['waste_water_meter'])
            ->setWaterMeter($data['water_meter']);
        return $flatMeter;
    }

    public function createFlatPrices(Flat $flat, array $data)
    {
        $this->createFlatPricePower($flat, $data);
    }

    public function createFlatPricePower(Flat $flat, array $data)
    {
        if ($data['power_price_full'] || $data['power_price_meter']) {
            $flatPowerConfig = new FlatPowerConfig();
            $configType = $this->entityManager->getRepository('Orm:ConfigType')->find($data['config_type']);
            $flatPowerConfig->setFlat($flat)
                ->setPriceFull($data['power_price_full'])
                ->setPriceMeter($data['power_price_meter'])
                ->setConfigType($configType);
            $this->entityManager->persist($flatPowerConfig);
        }
    }

    public function createFlatPriceGas(Flat $flat, array $data)
    {
        if ($data['gas_price_full'] || $data['gas_price_meter']) {
            $flatGasConfig = new FlatGasConfig();
            $configType = $this->entityManager->getRepository('Orm:ConfigType')->find($data['config_type']);
            $flatGasConfig->setFlat($flat)
                ->setPriceFull($data['gas_price_full'])
                ->setPriceMeter($data['gas_price_meter'])
                ->setConfigType($configType);
            $this->entityManager->persist($flatGasConfig);
        }
    }

    public function createFlatPriceRent(Flat $flat, array $data)
    {
        if ($data['rent_price_full'] || $data['rent_price_meter']) {
            $flatRentConfig = new FlatRentConfig();
            $configType = $this->entityManager->getRepository('Orm:ConfigType')->find($data['config_type']);
            $flatRentConfig->setFlat($flat)
                ->setPriceFull($data['rent_price_full'])
                ->setPriceMeter($data['rent_price_meter'])
                ->setConfigType($configType);
            $this->entityManager->persist($flatRentConfig);
        }
    }

    public function createFlatPriceWater(Flat $flat, array $data)
    {
        if ($data['water_price_full'] || $data['water_price_meter']) {
            $flatWaterConfig = new FlatWaterConfig();
            $configType = $this->entityManager->getRepository('Orm:ConfigType')->find($data['config_type']);
            $flatWaterConfig->setFlat($flat)
                ->setPriceFull($data['water_price_full'])
                ->setPriceMeter($data['water_price_meter'])
                ->setConfigType($configType);
            $this->entityManager->persist($flatWaterConfig);
        }
    }

    public function createFlatPriceWasteWater(Flat $flat, array $data)
    {
        if ($data['waste_water_price_full'] || $data['waste_water_price_meter']) {
            $flatWasteWaterConfig = new FlatWasteWaterConfig();
            $configType = $this->entityManager->getRepository('Orm:ConfigType')->find($data['config_type']);
            $flatWasteWaterConfig->setFlat($flat)
                ->setPriceFull($data['waste_water_price_full'])
                ->setPriceMeter($data['waste_water_price_meter'])
                ->setConfigType($configType);
            $this->entityManager->persist($flatWasteWaterConfig);
        }
    }

    /**
     * @param Flat $flat
     * @param User $user
     * @param Role $role
     * @return \Doctrine\Common\Collections\Collection|null
     */
    public function addTenantToFlat(Flat $flat, User $user, Role $role)
    {

        $userFlat = new UserFlat();
        $userFlat->setFlat($flat);
        $userFlat->setUser($user);
        $userFlat->setRole($role);
        $userFlat->setCreatedAt(new \DateTime('now'));
        $this->entityManager->persist($userFlat);

        $this->entityManager->flush();
        $this->entityManager->refresh($flat);
        return $flat->getActiveUsersFlats();
    }

    //delete flat
}