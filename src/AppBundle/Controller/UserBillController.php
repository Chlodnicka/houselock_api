<?php
/**
 * Created by PhpStorm.
 * User: majac
 * Date: 28.03.2018
 * Time: 13:14
 */

namespace AppBundle\Controller;

use AppBundle\Service\UserBillService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class UserBillController extends Controller
{
    private $userBillService;

    public function __construct(UserBillService $userBillService)
    {
        $this->userBillService = $userBillService;
    }

    /**
     * @Route("/bill/{billId}/pay.{_format}", defaults={"_format": "json"}, requirements={"_format": "html|json"},  name="pay_bill")
     * @Method("GET")
     */
    public function payAction(Request $request)
    {
        return new JsonResponse(['pay']);
    }

}