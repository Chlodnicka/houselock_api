<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserBill
 *
 * @ORM\Table(name="user_bill", uniqueConstraints={@ORM\UniqueConstraint(name="id_UNIQUE", columns={"id"})}, indexes={@ORM\Index(name="fk_user_has_bill_bill1_idx", columns={"bill_id"}), @ORM\Index(name="fk_user_has_bill_user1_idx", columns={"user_id"}), @ORM\Index(name="fk_user_bill_flat1_idx", columns={"flat_id"}), @ORM\Index(name="fk_user_bill_payment_status1_idx", columns={"payment_status_id"})})
 * @ORM\Entity
 */
class UserBill
{
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    private $createdAt;

    /**
     * @var integer
     *
     * @ORM\Column(name="created_by", type="integer", nullable=false)
     */
    private $createdBy;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \AppBundle\Entity\Flat
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Flat")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="flat_id", referencedColumnName="id")
     * })
     */
    private $flat;

    /**
     * @var \AppBundle\Entity\PaymentStatus
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\PaymentStatus")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="payment_status_id", referencedColumnName="id")
     * })
     */
    private $paymentStatus;

    /**
     * @var \AppBundle\Entity\Bill
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Bill")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="bill_id", referencedColumnName="id")
     * })
     */
    private $bill;

    /**
     * @var \AppBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * })
     */
    private $user;

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     * @return UserBill
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return int
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * @param int $createdBy
     * @return UserBill
     */
    public function setCreatedBy($createdBy)
    {
        $this->createdBy = $createdBy;
        return $this;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return UserBill
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return Flat
     */
    public function getFlat()
    {
        return $this->flat;
    }

    /**
     * @param Flat $flat
     * @return UserBill
     */
    public function setFlat($flat)
    {
        $this->flat = $flat;
        return $this;
    }

    /**
     * @return PaymentStatus
     */
    public function getPaymentStatus()
    {
        return $this->paymentStatus;
    }

    /**
     * @param PaymentStatus $paymentStatus
     * @return UserBill
     */
    public function setPaymentStatus($paymentStatus)
    {
        $this->paymentStatus = $paymentStatus;
        return $this;
    }

    /**
     * @return Bill
     */
    public function getBill()
    {
        return $this->bill;
    }

    /**
     * @param Bill $bill
     * @return UserBill
     */
    public function setBill($bill)
    {
        $this->bill = $bill;
        return $this;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     * @return UserBill
     */
    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }


}

