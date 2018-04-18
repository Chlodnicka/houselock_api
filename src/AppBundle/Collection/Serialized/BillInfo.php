<?php
/**
 * Created by PhpStorm.
 * User: majac
 * Date: 18.04.2018
 * Time: 20:20
 */

namespace AppBundle\Collection\Serialized;

use AppBundle\Entity\User;

class BillInfo
{

    public function __construct(User $user)
    {
       $userFlats = $user->getActiveUserFlats();
       foreach ($userFlats as $userFlat) {
           $flat = $userFlat->getFlat();
           $flat->getBills();
       }
    }

}