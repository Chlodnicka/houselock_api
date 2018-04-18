<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FlatRentConfig
 *
 * @ORM\Table(name="flat_rent_config", uniqueConstraints={@ORM\UniqueConstraint(name="flat_id_UNIQUE", columns={"flat_id"}), @ORM\UniqueConstraint(name="id_UNIQUE", columns={"id"})}, indexes={@ORM\Index(name="fk_flat_config_flat1_idx", columns={"flat_id"}), @ORM\Index(name="fk_flat_rent_config_config_type1_idx", columns={"config_type_id"})})
 * @ORM\Entity
 */
class FlatRentConfig
{
    /**
     * @var float
     *
     * @ORM\Column(name="price_full", type="float", precision=10, scale=0, nullable=true)
     */
    private $priceFull;

    /**
     * @var float
     *
     * @ORM\Column(name="price_meter", type="float", precision=10, scale=0, nullable=true)
     */
    private $priceMeter;

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
     * @ORM\OneToOne(targetEntity="Flat", inversedBy="rentConfig")
     * @ORM\JoinColumn(name="flat_id", referencedColumnName="id")
     */
    private $flat;

    /**
     * @var \AppBundle\Entity\ConfigType
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\ConfigType")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="config_type_id", referencedColumnName="id")
     * })
     */
    private $configType;

    /**
     * @return float
     */
    public function getPriceFull()
    {
        return $this->priceFull;
    }

    /**
     * @param float $priceFull
     * @return FlatRentConfig
     */
    public function setPriceFull($priceFull)
    {
        $this->priceFull = $priceFull;
        return $this;
    }

    /**
     * @return float
     */
    public function getPriceMeter()
    {
        return $this->priceMeter;
    }

    /**
     * @param float $priceMeter
     * @return FlatRentConfig
     */
    public function setPriceMeter($priceMeter)
    {
        $this->priceMeter = $priceMeter;
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
     * @return FlatRentConfig
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
     * @return FlatRentConfig
     */
    public function setFlat($flat)
    {
        $this->flat = $flat;
        return $this;
    }

    /**
     * @return ConfigType
     */
    public function getConfigType()
    {
        return $this->configType;
    }

    /**
     * @param ConfigType $configType
     * @return FlatRentConfig
     */
    public function setConfigType($configType)
    {
        $this->configType = $configType;
        return $this;
    }


}

