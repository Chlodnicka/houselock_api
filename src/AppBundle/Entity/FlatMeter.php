<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FlatMeter
 *
 * @ORM\Table(name="flat_meter", uniqueConstraints={@ORM\UniqueConstraint(name="id_UNIQUE", columns={"id"})}, indexes={@ORM\Index(name="fk_flat_meter_flat1_idx", columns={"flat_id"})})
 * @ORM\Entity
 */
class FlatMeter
{
    /**
     * @var float
     *
     * @ORM\Column(name="water_meter", type="float", precision=10, scale=0, nullable=true)
     */
    private $waterMeter;

    /**
     * @var float
     *
     * @ORM\Column(name="waste_water_meter", type="float", precision=10, scale=0, nullable=true)
     */
    private $wasteWaterMeter;

    /**
     * @var float
     *
     * @ORM\Column(name="power_meter", type="float", precision=10, scale=0, nullable=true)
     */
    private $powerMeter;

    /**
     * @var float
     *
     * @ORM\Column(name="gas_meter", type="float", precision=10, scale=0, nullable=true)
     */
    private $gasMeter;

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
     * @ORM\Column(name="modified_at", type="datetime", nullable=true)
     */
    private $modifiedAt;

    /**
     * @var integer
     *
     * @ORM\Column(name="modified_by", type="integer", nullable=true)
     */
    private $modifiedBy;

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
     * @ORM\ManyToOne(targetEntity="Flat", inversedBy="flatMeters")
     * @ORM\@JoinColumn(name="flat_id", referencedColumnName="id")
     */
    private $flat;

    /**
     * @return float
     */
    public function getWaterMeter()
    {
        return $this->waterMeter;
    }

    /**
     * @param float $waterMeter
     * @return FlatMeter
     */
    public function setWaterMeter($waterMeter)
    {
        $this->waterMeter = $waterMeter;
        return $this;
    }

    /**
     * @return float
     */
    public function getWasteWaterMeter()
    {
        return $this->wasteWaterMeter;
    }

    /**
     * @param float $wasteWaterMeter
     * @return FlatMeter
     */
    public function setWasteWaterMeter($wasteWaterMeter)
    {
        $this->wasteWaterMeter = $wasteWaterMeter;
        return $this;
    }

    /**
     * @return float
     */
    public function getPowerMeter()
    {
        return $this->powerMeter;
    }

    /**
     * @param float $powerMeter
     * @return FlatMeter
     */
    public function setPowerMeter($powerMeter)
    {
        $this->powerMeter = $powerMeter;
        return $this;
    }

    /**
     * @return float
     */
    public function getGasMeter()
    {
        return $this->gasMeter;
    }

    /**
     * @param float $gasMeter
     * @return FlatMeter
     */
    public function setGasMeter($gasMeter)
    {
        $this->gasMeter = $gasMeter;
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
     * @return FlatMeter
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
     * @return FlatMeter
     */
    public function setCreatedBy($createdBy)
    {
        $this->createdBy = $createdBy;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getModifiedAt()
    {
        return $this->modifiedAt;
    }

    /**
     * @param \DateTime $modifiedAt
     * @return FlatMeter
     */
    public function setModifiedAt($modifiedAt)
    {
        $this->modifiedAt = $modifiedAt;
        return $this;
    }

    /**
     * @return int
     */
    public function getModifiedBy()
    {
        return $this->modifiedBy;
    }

    /**
     * @param int $modifiedBy
     * @return FlatMeter
     */
    public function setModifiedBy($modifiedBy)
    {
        $this->modifiedBy = $modifiedBy;
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
     * @return FlatMeter
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
     * @return FlatMeter
     */
    public function setFlat($flat)
    {
        $this->flat = $flat;
        return $this;
    }


}

