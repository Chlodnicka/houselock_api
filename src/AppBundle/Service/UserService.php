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
use AppBundle\Repository\RoleRepository;
use AppBundle\Repository\UserRepository;
use AppBundle\Repository\UserStatusRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserService
{

    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var RoleRepository
     */
    private $roleRepository;


    /**
     * @var UserStatusRepository
     */
    private $userStatusRepository;

    /**
     * UserService constructor.
     * @param UserRepository $userRepository
     * @param RoleRepository $roleRepository
     */
    public function __construct(UserRepository $userRepository, RoleRepository $roleRepository, UserStatusRepository $userStatusRepository)
    {
        $this->userRepository = $userRepository;
        $this->roleRepository = $roleRepository;
        $this->userStatusRepository = $userStatusRepository;
    }

    /**
     * @param int $id
     * @return User|null
     */
    public function get(int $id)
    {
        return $this->userRepository->get($id);
    }

    /**
     * @param User $user
     * @param UserPasswordEncoderInterface $passwordEncoder
     */
    public function registerUser(User $user, UserPasswordEncoderInterface $passwordEncoder)
    {
        $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
        $landlordRole = $this->roleRepository->getLandlord();
        $user->setPassword($password);
        $user->setCreatedAt(new \DateTime('now'));
        $user->setCreatedBy('1');
        $user->addRole($landlordRole);
        $landlordRole->addUser($user);

        $this->userRepository->registerUser($user, $landlordRole);
    }

    /**
     * @param User $user
     * @param int $userId
     * @return bool
     */
    public function checkUserRights(User $user, User $userToDisplay)
    {
        $userToDisplayFlats = [];
        foreach ($userToDisplay->getActiveUserFlats() as $userFlat) {
            $userToDisplayFlats[] = $userFlat->getFlat();
        }

        foreach ($user->getActiveUserFlats() as $userFlat) {
            if (in_array($userFlat->getFlat(), $userToDisplayFlats)) {
                return true;
            }
        }

        return false;
    }

    public function updateUser(User $user, $data)
    {
        return $this->userRepository->updateUser($user, $data);
    }


    public function setPassword(User $user, UserPasswordEncoderInterface $userPasswordEncoder, $data)
    {
        $user->setPlainPassword($data['password']);
        $password = $userPasswordEncoder->encodePassword($user, $user->getPlainPassword());
        $user->setPassword($password);
        return $this->userRepository->saveUser($user);
    }

    /**
     * @param User $user
     * @param string $email
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return User|null
     */
    public function addTenant(User $user, string $email, UserPasswordEncoderInterface $passwordEncoder)
    {
        $tenant = $this->userRepository->getOneByCriteria(['email' => $email]);
        if (!$tenant) {
            $tenant = new User();
            $tenant->setEmail($email);
            $tenant->setPlainPassword(rand(100000, 9999999));
            $plain = $tenant->getPlainPassword();
            $password = $passwordEncoder->encodePassword($tenant, $tenant->getPlainPassword());
            $tenantRole = $this->roleRepository->getTenant();
            $tenant->setPassword($password);
            $tenant->setCreatedAt(new \DateTime('now'));
            $tenant->setCreatedBy($user->getId());
            $tenant->setUserStatus($this->userStatusRepository->getTemp());
            $tenant->addRole($tenantRole);
            $tenantRole->addUser($tenant);
            $this->userRepository->registerUser($tenant, $tenantRole);

            //send password to user

        }
        return $tenant;
    }

    public function addTenants(User $user, array $userEmails)
    {
        $tenants = $errors = [];
        $tenantRole = $this->roleRepository->getTenant();
        foreach ($userEmails as $email) {
            $tenant = $this->userRepository->getOneByCriteria(['email' => $email]);
            if ($tenant && $tenant->getActiveUserFlats()) {
                $errors[] = ['message' => 'user_already_has_flat', 'email' => $email];
            } else {
                if ($tenant) {
                    $tenants[] = $this->userRepository->updateTenant($tenant);
                } else {
                    $tenants[] = $this->userRepository->createTenant($user, $email, $tenantRole);
                }
            }
        }
        return ['tenants' => $tenants, 'errors' => $errors];
    }
}