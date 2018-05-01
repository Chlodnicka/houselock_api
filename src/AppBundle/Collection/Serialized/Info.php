<?php
/**
 * Created by PhpStorm.
 * User: majac
 * Date: 18.04.2018
 * Time: 18:42
 */

namespace AppBundle\Collection\Serialized;


use AppBundle\Entity\Flat;
use AppBundle\Entity\FlatGasConfig;
use AppBundle\Entity\FlatPowerConfig;
use AppBundle\Entity\FlatRentConfig;
use AppBundle\Entity\FlatWasteWaterConfig;
use AppBundle\Entity\FlatWaterConfig;
use AppBundle\Entity\User;
use AppBundle\Entity\UserFlat;

class Info
{
    protected $user;

    protected $flats;

    public function __construct(User $user)
    {
        $this->user = $this->serializeUser($user);
        $this->flats = $this->serializeFlats($user);
    }

    protected function serializeUser(User $user)
    {
        return [
            'id' => $user->getId(),
            'fullname' => $user->getFirstname() . ' ' . $user->getLastname(),
            'firstname' => $user->getFirstname(),
            'lastname' => $user->getLastname(),
            'email' => $user->getEmail(),
            'role' => $user->getRoles(),
            'phone' => $user->getPhone()
        ];
    }

    protected function serializeFlats(User $user)
    {
        $flatsData = [];
        foreach ($user->getActiveUserFlats() as $userFlat) {
            /**
             * @var $flat Flat
             */
            $flat = $userFlat->getFlat();
            $flatsData[$flat->getId()] = [
                'id' => $flat->getId(),
                'name' => $flat->getName(),
                'building_number' => $flat->getBuildingNumber(),
                'flat_number' => $flat->getFlatNumber(),
                'street' => $flat->getStreet(),
                'city' => $flat->getCity(),
                'postal_code' => $flat->getPostalCode(),
                'flat_config' => $this->serializeFlatConfig($flat)
            ];
        }
        return $flatsData;
    }

    protected function serializeFlatConfig(Flat $flat)
    {
        $config = [];
        if ($flat->getGasConfig()) {
            /**
             * @var $gasConfig FlatGasConfig
             */
            $gasConfig = $flat->getGasConfig();
            $config['gas'] = [
                'price_full' => $gasConfig->getPriceFull(),
                'price_meter' => $gasConfig->getPriceMeter(),
                'config_type' => $gasConfig->getConfigType()->getName(),
                'config_type_id' => $gasConfig->getConfigType()->getId()
            ];
        }
        if ($flat->getPowerConfig()) {
            /**
             * @var $powerConfig FlatPowerConfig
             */
            $powerConfig = $flat->getPowerConfig();
            $config['power'] = [
                'price_full' => $powerConfig->getPriceFull(),
                'price_meter' => $powerConfig->getPriceMeter(),
                'config_type' => $powerConfig->getConfigType()->getName(),
                'config_type_id' => $powerConfig->getConfigType()->getId()
            ];
        }
        if ($flat->getWaterConfig()) {
            /**
             * @var $waterConfig FlatWaterConfig
             */
            $waterConfig = $flat->getWaterConfig();
            $config['water'] = [
                'price_full' => $waterConfig->getPriceFull(),
                'price_meter' => $waterConfig->getPriceMeter(),
                'config_type' => $waterConfig->getConfigType()->getName(),
                'config_type_id' => $waterConfig->getConfigType()->getId()
            ];
        }
        if ($flat->getWasteWaterConfig()) {
            /**
             * @var $wasteWaterConfig FlatWasteWaterConfig
             */
            $wasteWaterConfig = $flat->getWasteWaterConfig();
            $config['waste_water'] = [
                'price_full' => $wasteWaterConfig->getPriceFull(),
                'price_meter' => $wasteWaterConfig->getPriceMeter(),
                'config_type' => $wasteWaterConfig->getConfigType()->getName(),
                'config_type_id' => $wasteWaterConfig->getConfigType()->getId()
            ];
        }
        if ($flat->getRentConfig()) {
            /**
             * @var $rentConfig FlatRentConfig
             */
            $rentConfig = $flat->getRentConfig();
            $config['rent'] = [
                'price_full' => $rentConfig->getPriceFull(),
                'price_meter' => $rentConfig->getPriceMeter(),
                'config_type' => $rentConfig->getConfigType()->getName(),
                'config_type_id' => $rentConfig->getConfigType()->getId()
            ];
        }
        return $config;
    }

    public function getAll()
    {
        return [
            'user_info' => $this->user,
            'user_flats' => $this->flats
        ];
    }

}