<?php
/**
 * Created by PhpStorm.
 * User: majac
 * Date: 28.03.2018
 * Time: 14:07
 */

namespace AppBundle\Service;

use AppBundle\Repository\BillRepository;

class BillService
{
    private $billRepository;

    public function __construct(BillRepository $billRepository)
    {
        $this->billRepository = $billRepository;
    }

    public function test()
    {
        $bills = $this->billRepository->getAll();
        dump($bills);
    }

}