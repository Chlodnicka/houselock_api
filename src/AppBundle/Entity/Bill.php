<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Bill
 *
 * @ORM\Table(name="bill", uniqueConstraints={@ORM\UniqueConstraint(name="id_UNIQUE", columns={"id"})}, indexes={@ORM\Index(name="fk_bill_flat1_idx", columns={"flat_id"}), @ORM\Index(name="fk_bill_payment_status1_idx", columns={"payment_status_id"})})
 * @ORM\Entity
 */
class Bill
{
    /**
     * @var float
     *
     * @ORM\Column(name="water_price", type="float", precision=10, scale=0, nullable=true)
     */
    private $waterPrice;

    /**
     * @var float
     *
     * @ORM\Column(name="waste_water_price", type="float", precision=10, scale=0, nullable=true)
     */
    private $wasteWaterPrice;

    /**
     * @var float
     *
     * @ORM\Column(name="power_price", type="float", precision=10, scale=0, nullable=true)
     */
    private $powerPrice;

    /**
     * @var float
     *
     * @ORM\Column(name="gas_price", type="float", precision=10, scale=0, nullable=true)
     */
    private $gasPrice;

    /**
     * @var float
     *
     * @ORM\Column(name="rent_price", type="float", precision=10, scale=0, nullable=true)
     */
    private $rentPrice;

    /**
     * @var float
     *
     * @ORM\Column(name="tv_price", type="float", precision=10, scale=0, nullable=true)
     */
    private $tvPrice;

    /**
     * @var float
     *
     * @ORM\Column(name="internet_price", type="float", precision=10, scale=0, nullable=true)
     */
    private $internetPrice;

    /**
     * @var float
     *
     * @ORM\Column(name="sum", type="float", precision=10, scale=0, nullable=true)
     */
    private $sum;

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
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @var integer
     *
     * @ORM\Column(name="updated_by", type="integer", nullable=true)
     */
    private $updatedBy;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="deleted_at", type="datetime", nullable=true)
     */
    private $deletedAt;

    /**
     * @var integer
     *
     * @ORM\Column(name="deleted_by", type="integer", nullable=true)
     */
    private $deletedBy;

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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Flat", inversedBy="bills")
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
     * @return float
     */
    public function getWaterPrice()
    {
        return $this->waterPrice;
    }

    /**
     * @param float $waterPrice
     * @return Bill
     */
    public function setWaterPrice($waterPrice)
    {
        $this->waterPrice = $waterPrice;
        return $this;
    }

    /**
     * @return float
     */
    public function getWasteWaterPrice()
    {
        return $this->wasteWaterPrice;
    }

    /**
     * @param float $wasteWaterPrice
     * @return Bill
     */
    public function setWasteWaterPrice($wasteWaterPrice)
    {
        $this->wasteWaterPrice = $wasteWaterPrice;
        return $this;
    }

    /**
     * @return float
     */
    public function getPowerPrice()
    {
        return $this->powerPrice;
    }

    /**
     * @param float $powerPrice
     * @return Bill
     */
    public function setPowerPrice($powerPrice)
    {
        $this->powerPrice = $powerPrice;
        return $this;
    }

    /**
     * @return float
     */
    public function getGasPrice()
    {
        return $this->gasPrice;
    }

    /**
     * @param float $gasPrice
     * @return Bill
     */
    public function setGasPrice($gasPrice)
    {
        $this->gasPrice = $gasPrice;
        return $this;
    }

    /**
     * @return float
     */
    public function getRentPrice()
    {
        return $this->rentPrice;
    }

    /**
     * @param float $rentPrice
     * @return Bill
     */
    public function setRentPrice($rentPrice)
    {
        $this->rentPrice = $rentPrice;
        return $this;
    }

    /**
     * @return float
     */
    public function getTvPrice()
    {
        return $this->tvPrice;
    }

    /**
     * @param float $tvPrice
     * @return Bill
     */
    public function setTvPrice($tvPrice)
    {
        $this->tvPrice = $tvPrice;
        return $this;
    }

    /**
     * @return float
     */
    public function getInternetPrice()
    {
        return $this->internetPrice;
    }

    /**
     * @param float $internetPrice
     * @return Bill
     */
    public function setInternetPrice($internetPrice)
    {
        $this->internetPrice = $internetPrice;
        return $this;
    }

    /**
     * @return float
     */
    public function getSum()
    {
        return $this->sum;
    }

    /**
     * @param float $sum
     * @return Bill
     */
    public function setSum($sum)
    {
        $this->sum = $sum;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     * @return Bill
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
     * @return Bill
     */
    public function setCreatedBy($createdBy)
    {
        $this->createdBy = $createdBy;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime $updatedAt
     * @return Bill
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    /**
     * @return int
     */
    public function getUpdatedBy()
    {
        return $this->updatedBy;
    }

    /**
     * @param int $updatedBy
     * @return Bill
     */
    public function setUpdatedBy($updatedBy)
    {
        $this->updatedBy = $updatedBy;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDeletedAt()
    {
        return $this->deletedAt;
    }

    /**
     * @param \DateTime $deletedAt
     * @return Bill
     */
    public function setDeletedAt($deletedAt)
    {
        $this->deletedAt = $deletedAt;
        return $this;
    }

    /**
     * @return int
     */
    public function getDeletedBy()
    {
        return $this->deletedBy;
    }

    /**
     * @param int $deletedBy
     * @return Bill
     */
    public function setDeletedBy($deletedBy)
    {
        $this->deletedBy = $deletedBy;
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
     * @return Bill
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
     * @return Bill
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
     * @return Bill
     */
    public function setPaymentStatus($paymentStatus)
    {
        $this->paymentStatus = $paymentStatus;
        return $this;
    }


}

