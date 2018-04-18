<?php
/**
 * Created by PhpStorm.
 * User: majac
 * Date: 28.03.2018
 * Time: 13:14
 */

namespace AppBundle\Controller;

use AppBundle\Service\BillService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class BillController extends Controller
{
    private $billService;

    public function __construct(BillService $billService)
    {
        $this->billService = $billService;
    }

    /**
     * @Route("/api/bill/list/{flatId}.{_format}", defaults={"_format": "json"}, requirements={"_format": "html|json"},  name="flat_bills_list")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        //get list of bills for flat (historical)
        return new JsonResponse(['flat_bills']);
    }

    /**
     * @Route("/api/bill/{billId}.{_format}", defaults={"_format": "json"}, requirements={"_format": "html|json"},  name="bill")
     * @Method("GET")
     */
    public function showAction(Request $request)
    {
        //get bill info
        return new JsonResponse(['bill_info']);
    }

    /**
     * @Route("/api/bill.{_format}", defaults={"_format": "json"}, requirements={"_format": "html|json"},  name="bill")
     * @Method("GET")
     */
    public function showLastAction(Request $request)
    {
        //get last bill info
        return new JsonResponse(['bill_info']);
    }

    //action to autmatic creation of bills and users bills

    /**
     * @Route("/api/bill/{billId}/update.{_format}", defaults={"_format": "json"}, requirements={"_format": "html|json"},  name="bill_update")
     * @Method("GET")
     */
    public function updateAction(Request $request)
    {
        //update bill info (prices)
        return new JsonResponse(['bill_update']);
    }

    /**
     * @Route("/api/bill/{billId}/payed.{_format}", defaults={"_format": "json"}, requirements={"_format": "html|json"},  name="bill_payed")
     * @Method("GET")
     */
    public function payedAction(Request $request)
    {
        //mark bill as payed
        return new JsonResponse(['bill_mark_as_payed_update']);
    }

}