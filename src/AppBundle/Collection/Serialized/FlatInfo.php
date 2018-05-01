<?php
/**
 * Created by PhpStorm.
 * User: majac
 * Date: 27.04.2018
 * Time: 16:44
 */

namespace AppBundle\Collection\Serialized;


use AppBundle\Entity\Bill;
use AppBundle\Entity\Flat;
use AppBundle\Entity\User;
use AppBundle\Entity\UserFlat;

class FlatInfo
{

    /**
     * @var array
     */
    private $currentBill;

    /**
     * @var array
     */
    private $bills;

    private $tenants;

    /**
     * FlatInfo constructor.
     * @param Flat $flat
     */
    public function __construct(Flat $flat)
    {
        $this->currentBill = $this->serializeBill($flat->getLastBill());
        $this->bills = $this->serializeBills($flat->getBills());
        $this->tenants = $this->serializeTenants($flat->getTenants());
    }

    protected function serializeTenants($tenants)
    {
        $tenantsData = [];
        foreach ($tenants as $tenant) {
            /**
             * @var $user User
             */
            $user = $tenant->getUser();
            $tenantsData[$user->getId()] = $this->serializeUser($user);
        }
        return $tenantsData;
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

    /**
     * @param Bill $bill
     * @return array
     */
    private function serializeBill(Bill $bill)
    {

        return [
            'id' => $bill->getId(),
            'gas_price' => $bill->getGasPrice(),
            'internet_price' => $bill->getInternetPrice(),
            'power_price' => $bill->getPowerPrice(),
            'rent_price' => $bill->getRentPrice(),
            'tv_price' => $bill->getTvPrice(),
            'water_price' => $bill->getWaterPrice(),
            'waste_water_price' => $bill->getWasteWaterPrice(),
            'sum' => $bill->getSum(),
            'payment_status' => $bill->getPaymentStatus()->getName(),
            'month' => date_format($bill->getCreatedAt(), 'F'),
            'year' => date_format($bill->getCreatedAt(), 'Y'),
            'created_at' => date_format($bill->getCreatedAt(), 'Y-m-d H:i:s')
        ];
    }

    /**
     * @param $bills
     * @return array
     */
    private function serializeBills($bills)
    {
        $serializedBills = [];
        foreach ($bills as $bill) {
            $serializedBills[] = $this->serializeBill($bill);
        }
        return $serializedBills;
    }

    /**
     * @return array
     */
    public function getAll()
    {
        return [
            'last_bill' => $this->currentBill,
            'bills' => $this->bills,
            'tenants' => $this->tenants
        ];
    }

}