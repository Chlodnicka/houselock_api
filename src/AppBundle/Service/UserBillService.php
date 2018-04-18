<?php
/**
 * Created by PhpStorm.
 * User: majac
 * Date: 28.03.2018
 * Time: 14:07
 */

namespace AppBundle\Service;

use AppBundle\Repository\UserBillRepository;

class UserBillService
{

    private $userBillRepository;

    public function __construct(UserBillRepository $userBillRepository)
    {
        $this->userBillRepository = $userBillRepository;
    }

}