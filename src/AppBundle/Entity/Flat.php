<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Flat
 *
 * @ORM\Table(name="flat", uniqueConstraints={@ORM\UniqueConstraint(name="id_UNIQUE", columns={"id"})})
 * @ORM\Entity
 */
class Flat
{
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="street", type="string", length=255, nullable=false)
     */
    private $street;

    /**
     * @var string
     *
     * @ORM\Column(name="flat_number", type="string", length=10, nullable=true)
     */
    private $flatNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="building_number", type="string", length=10, nullable=false)
     */
    private $buildingNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="postal_code", type="string", length=10, nullable=false)
     */
    private $postalCode;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=255, nullable=false)
     */
    private $city;

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
     * @var FlatMeter
     *
     * @ORM\OneToMany(targetEntity="FlatMeter", mappedBy="flat")
     */
    private $flatMeters;

    /**
     * @var Bill
     *
     * @ORM\OneToMany(targetEntity="Bill", mappedBy="flat")
     */
    private $bills;

    /**
     * @ORM\OneToMany(targetEntity="UserFlat", mappedBy="flat")
     */
    private $userFlats;

    /**
     * @var \AppBundle\Entity\FlatWaterConfig
     *
     * @ORM\OneToOne(targetEntity="FlatWaterConfig", mappedBy="flat")
     */
    private $waterConfig;

    /**
     * @var \AppBundle\Entity\FlatWasteWaterConfig
     *
     * @ORM\OneToOne(targetEntity="FlatWasteWaterConfig", mappedBy="flat")
     */
    private $wasteWaterConfig;

    /**
     * @var \AppBundle\Entity\FlatRentConfig
     *
     * @ORM\OneToOne(targetEntity="FlatRentConfig", mappedBy="flat")
     */
    private $rentConfig;

    /**
     * @var \AppBundle\Entity\FlatGasConfig
     *
     * @ORM\OneToOne(targetEntity="FlatGasConfig", mappedBy="flat")
     */
    private $gasConfig;

    /**
     * @var \AppBundle\Entity\FlatPowerConfig
     *
     * @ORM\OneToOne(targetEntity="FlatPowerConfig", mappedBy="flat")
     */
    private $powerConfig;

    public function __construct()
    {
        $this->userFlats = new ArrayCollection();
        $this->flatMeters = new ArrayCollection();
        $this->bills = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Flat
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * @param string $street
     * @return Flat
     */
    public function setStreet($street)
    {
        $this->street = $street;
        return $this;
    }

    /**
     * @return string
     */
    public function getFlatNumber()
    {
        return $this->flatNumber;
    }

    /**
     * @param string $flatNumber
     * @return Flat
     */
    public function setFlatNumber($flatNumber)
    {
        $this->flatNumber = $flatNumber;
        return $this;
    }

    /**
     * @return string
     */
    public function getBuildingNumber()
    {
        return $this->buildingNumber;
    }

    /**
     * @param string $buildingNumber
     * @return Flat
     */
    public function setBuildingNumber($buildingNumber)
    {
        $this->buildingNumber = $buildingNumber;
        return $this;
    }

    /**
     * @return string
     */
    public function getPostalCode()
    {
        return $this->postalCode;
    }

    /**
     * @param string $postalCode
     * @return Flat
     */
    public function setPostalCode($postalCode)
    {
        $this->postalCode = $postalCode;
        return $this;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param string $city
     * @return Flat
     */
    public function setCity($city)
    {
        $this->city = $city;
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
     * @return Flat
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
     * @return Flat
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
     * @return Flat
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
     * @return Flat
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
     * @return Flat
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
     * @return Flat
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
     * @return Flat
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFlatMeters()
    {
        return $this->flatMeters;
    }

    /**
     * @param FlatMeter $flatMeter
     * @return Flat
     */
    public function addFlatMeter(FlatMeter $flatMeter): Flat
    {
        $this->flatMeters[] = $flatMeter;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUserFlats()
    {
        return $this->userFlats;
    }

    /**
     * @param mixed $userFlats
     * @return Flat
     */
    public function addUserFlats($userFlats)
    {
        $this->userFlats[] = $userFlats;
        return $this;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection|null
     */
    public function getActiveUsersFlats()
    {
        $userFlats = $this->userFlats->filter(function (UserFlat $userFlat) {
            return $userFlat->getDeletedAt() === null;
        });
        if ($userFlats) {
            return $userFlats;
        }
        return null;
    }

    public function getTenants()
    {
        $userFlats = $this->userFlats->filter(function (UserFlat $userFlat) {
            return in_array('ROLE_TENANT', $userFlat->getUser()->getRoles());
        });

        if ($userFlats) {
            return $userFlats;
        }
        return null;
    }

    /**
     * @return FlatWaterConfig
     */
    public function getWaterConfig(): FlatWaterConfig
    {
        return $this->waterConfig;
    }

    /**
     * @param FlatWaterConfig $waterConfig
     * @return Flat
     */
    public function setWaterConfig(FlatWaterConfig $waterConfig): Flat
    {
        $this->waterConfig = $waterConfig;
        return $this;
    }

    /**
     * @return FlatWasteWaterConfig
     */
    public function getWasteWaterConfig(): FlatWasteWaterConfig
    {
        return $this->wasteWaterConfig;
    }

    /**
     * @param FlatWasteWaterConfig $wasteWaterConfig
     * @return Flat
     */
    public function setWasteWaterConfig(FlatWasteWaterConfig $wasteWaterConfig): Flat
    {
        $this->wasteWaterConfig = $wasteWaterConfig;
        return $this;
    }

    /**
     * @return FlatRentConfig
     */
    public function getRentConfig(): FlatRentConfig
    {
        return $this->rentConfig;
    }

    /**
     * @param FlatRentConfig $rentConfig
     * @return Flat
     */
    public function setRentConfig(FlatRentConfig $rentConfig): Flat
    {
        $this->rentConfig = $rentConfig;
        return $this;
    }

    /**
     * @return FlatGasConfig
     */
    public function getGasConfig(): FlatGasConfig
    {
        return $this->gasConfig;
    }

    /**
     * @param FlatGasConfig $gasConfig
     * @return Flat
     */
    public function setGasConfig(FlatGasConfig $gasConfig): Flat
    {
        $this->gasConfig = $gasConfig;
        return $this;
    }

    /**
     * @return FlatPowerConfig
     */
    public function getPowerConfig(): FlatPowerConfig
    {
        return $this->powerConfig;
    }

    /**
     * @param FlatPowerConfig $powerConfig
     * @return Flat
     */
    public function setPowerConfig(FlatPowerConfig $powerConfig): Flat
    {
        $this->powerConfig = $powerConfig;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBills()
    {
        return $this->bills;
    }

    /**
     * @param Bill $bill
     * @return Flat
     */
    public function addBill(Bill $bill): Flat
    {
        $this->bills[] = $bill;
        return $this;
    }

    public function getLastBill() {
        return $this->bills->last();
    }
}

