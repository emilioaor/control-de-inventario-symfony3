<?php

namespace InvEO\ClientAndSupplierBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use InvEO\CoreBundle\Entity\BaseEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * ClientAndSupplier
 *
 * @ORM\Table(name="client_and_supplier")
 * @ORM\Entity(repositoryClass="InvEO\ClientAndSupplierBundle\Repository\ClientAndSupplierRepository")
 * @author Emilio Ochoa http://emilioochoa.com.ve
 */
class ClientAndSupplier extends BaseEntity
{
    /** Mascaras */
    const CLIENT_MASK = '{CLI}{000000}';
    const SUPPLIER_MASK = '{PRO}{000000}';
    /** Status como cliente y proveedores */
    const CLIENT_ACTIVE = 1;
    const CLIENT_INACTIVE = 0;
    const SUPPLIER_ACTIVE = 1;
    const SUPPLIER_INACTIVE = 0;

    /**
     * @var string
     *
     * @ORM\Column(name="code", type="string", length=80, unique=true)
     */
    private $code;

    /**
     * @var string
     *
     * @ORM\Column(name="rif", type="string", length=20, unique=true)
     * @Assert\NotBlank(message="Rif no puede ser vacio")
     * @Assert\Regex(pattern="/^[V|G|J|E]-[0-9]{8}-[0-9]{1}$/", message="Rif {{ value }} debe poseer el formato V-00000000-0 | J-00000000-0 | G-00000000-0")
     */
    private $rif;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=50, unique=true)
     * @Assert\NotBlank(message="Nombre no puede ser vacio")
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=255, nullable=true)
     */
    private $address;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=11, nullable=true)
     * @Assert\NotBlank(message="Telefono no puede ser vacio")
     * @Assert\Regex(pattern="/^[0-9]{11}$/", message="Telefono {{ value }} debe poseer el formato 02**0000000")
     */
    private $phone;

    /**
     * @var string
     *
     * @ORM\Column(name="mobile", type="string", length=11, nullable=true)
     * @Assert\NotBlank(message="Celular no puede ser vacio")
     * @Assert\Regex(pattern="/^[0-9]{11}$/", message="Celular {{ value }} debe poseer el formato 04**0000000")
     */
    private $mobile;

    /**
     * @var int
     *
     * @ORM\Column(name="client_active", type="integer")
     */
    private $clientActive;

    /**
     * @var int
     *
     * @ORM\Column(name="supplier_active", type="integer")
     */
    private $supplierActive;

    /**
     * @var \InvEO\InventoryMovementBundle\Entity\InventoryMovement
     * @ORM\OneToMany(targetEntity="InvEO\InventoryMovementBundle\Entity\InventoryMovement", mappedBy="clientAndSupplier")
     */
    private $inventoryMovements;

    /**
     * Metodo constructor
     */
    public function __construct()
    {
        $this->inventoryMovements = new ArrayCollection();
    }


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set rif
     *
     * @param string $rif
     *
     * @return ClientAndSupplier
     */
    public function setRif($rif)
    {
        $this->rif = $rif;

        return $this;
    }

    /**
     * Get rif
     *
     * @return string
     */
    public function getRif()
    {
        return $this->rif;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return ClientAndSupplier
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set address
     *
     * @param string $address
     *
     * @return ClientAndSupplier
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set phone
     *
     * @param string $phone
     *
     * @return ClientAndSupplier
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set mobile
     *
     * @param string $mobile
     *
     * @return ClientAndSupplier
     */
    public function setMobile($mobile)
    {
        $this->mobile = $mobile;

        return $this;
    }

    /**
     * Get mobile
     *
     * @return string
     */
    public function getMobile()
    {
        return $this->mobile;
    }

    /**
     * Set clientActive
     *
     * @param integer $clientActive
     *
     * @return ClientAndSupplier
     */
    public function setClientActive($clientActive)
    {
        $this->clientActive = $clientActive;

        return $this;
    }

    /**
     * Get clientActive
     *
     * @return integer
     */
    public function getClientActive()
    {
        return $this->clientActive;
    }

    /**
     * Set supplierActive
     *
     * @param integer $supplierActive
     *
     * @return ClientAndSupplier
     */
    public function setSupplierActive($supplierActive)
    {
        $this->supplierActive = $supplierActive;

        return $this;
    }

    /**
     * Get supplierActive
     *
     * @return integer
     */
    public function getSupplierActive()
    {
        return $this->supplierActive;
    }

    /**
     * Set code
     *
     * @param string $code
     *
     * @return ClientAndSupplier
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @return \InvEO\InventoryMovementBundle\Entity\InventoryMovement
     */
    public function getInventoryMovements()
    {
        return $this->inventoryMovements;
    }

    /**
     * @param \InvEO\InventoryMovementBundle\Entity\InventoryMovement $inventoryMovements
     */
    public function setInventoryMovements($inventoryMovements)
    {
        $this->inventoryMovements = $inventoryMovements;
    }

}
