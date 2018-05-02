<?php
/**
 * Created by PhpStorm.
 * User: majac
 * Date: 28.03.2018
 * Time: 14:07
 */

namespace AppBundle\Service;

use AppBundle\Entity\Flat;
use AppBundle\Entity\User;
use AppBundle\Entity\UserFlat;
use AppBundle\Repository\FlatRepository;
use AppBundle\Repository\RoleRepository;

class FlatService
{
    /**
     * @var FlatRepository
     */
    private $flatRepository;

    /**
     * @var RoleRepository
     */
    private $roleRepository;

    public function __construct(FlatRepository $flatRepository, RoleRepository $roleRepository)
    {
        $this->flatRepository = $flatRepository;
        $this->roleRepository = $roleRepository;
    }

    /**
     * @param int $id
     * @return \AppBundle\Entity\Flat|null
     */
    public function getFlat(int $id)
    {
        return $this->flatRepository->get($id);
    }

    /**
     * @param User $user
     * @param $id
     * @return \AppBundle\Entity\Flat|null
     */
    public function checkUserFlat(User $user, $id)
    {
        /**
         * @var $userFlat UserFlat
         */
        $userFlat = $user->getUserFlats()->filter(function (UserFlat $userFlat) use ($id) {
            return $userFlat->getFlat()->getId() === $id && $userFlat->getFlat()->getDeletedAt() === null;
        })->first();

        if ($userFlat) {
            return $userFlat->getFlat();
        }

        return null;
    }

    /**
     * @param User $user
     * @param array $data
     * @return \AppBundle\Entity\Flat
     */
    public function createFlat(User $user, array $data)
    {
        return $this->flatRepository->createFlat($user, $data);
    }

    public function updateFlat(User $user, Flat $flat, array $data)
    {

        return $this->flatRepository->updateFlat($user, $flat, $data);
    }

    public function getTenants(Flat $flat)
    {
        //get role tennant
        $usersFlat = $flat->getUserFlats()->filter(function (UserFlat $userFlat) {
            return $userFlat->getUser()->getRoles() && $userFlat->getDeletedAt() == null;
        });
        if ($usersFlat) {
            return $usersFlat;
        }
        return null;
    }

    /**
     * @param Flat $flat
     * @param array $tenants
     */
    public function addTenantToFlat(Flat $flat, User $tenant)
    {
        $this->flatRepository->addTenantToFlat($flat, $tenant, $this->roleRepository->getTenant());
    }
}