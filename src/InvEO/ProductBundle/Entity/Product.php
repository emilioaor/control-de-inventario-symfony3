<?php

namespace InvEO\ProductBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

use InvEO\CoreBundle\Entity\BaseEntity;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Product
 *
 * @ORM\Table(name="product")
 * @ORM\Entity(repositoryClass="InvEO\ProductBundle\Repository\ProductRepository")
 */
class Product extends BaseEntity
{
    const MASK = '{PROD}{00000}';

    /**
     * @var string
     *
     * @ORM\Column(name="code", type="string", length=80, unique=true)
     */
    private $code;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=80, unique=true)
     * @Assert\NotBlank(message="Nombre no puede ser vacio")
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @var float
     *
     * @ORM\Column(name="price", type="decimal", precision=10, scale=2)
     * @Assert\NotBlank(message="Precio no puede ser vacio")
     * @Assert\Type(type="float", message="Precio no cumple el formato correcto")
     */
    private $price;

    /**
     * @var float
     *
     * @ORM\Column(name="stock", type="decimal", precision=10, scale=2)
     */
    private $stock;

    /**
     * @var float
     *
     * @ORM\Column(name="stock_maximum", type="decimal", precision=10, scale=2)
     * @Assert\NotBlank(message="Stock maximo no puede ser vacio")
     * @Assert\Type(type="float", message="Stock maximo no cumple el formato correcto")
     */
    private $stockMaximum;

    /**
     * @var float
     *
     * @ORM\Column(name="stock_minimum", type="decimal", precision=10, scale=2)
     * @Assert\NotBlank(message="Stock minimo no puede ser vacio")
     * @Assert\Type(type="float", message="Stock minimo no cumple el formato correcto")
     */
    private $stockMinimum;

    /**
     * @var float
     *
     * @ORM\Column(name="cost_maximum", type="decimal", precision=10, scale=2)
     */
    private $costMaximum;

    /**
     * @var float
     *
     * @ORM\Column(name="cost_minimum", type="decimal", precision=10, scale=2)
     */
    private $costMinimum;

    /**
     * @var float
     *
     * @ORM\Column(name="cost_average", type="decimal", precision=10, scale=2)
     */
    private $costAverage;

    /**
     * @var ArrayCollection<\InvEO\InventoryMovementBundle\Entity\Detail\InventoryMovementDetail>
     *
     * @ORM\OneToMany(targetEntity="InvEO\InventoryMovementBundle\Entity\Detail\InventoryMovementDetail", mappedBy="product")
     */
    private $inventoryMovementDetails;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->inventoryMovementDetails = new ArrayCollection();
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
     * Set name
     *
     * @param string $name
     *
     * @return Product
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
     * Set description
     *
     * @param string $description
     *
     * @return Product
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set price
     *
     * @param string $price
     *
     * @return Product
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set stockMaximum
     *
     * @param string $stockMaximum
     *
     * @return Product
     */
    public function setStockMaximum($stockMaximum)
    {
        $this->stockMaximum = $stockMaximum;

        return $this;
    }

    /**
     * Get stockMaximum
     *
     * @return string
     */
    public function getStockMaximum()
    {
        return $this->stockMaximum;
    }

    /**
     * Set stockMinimum
     *
     * @param string $stockMinimum
     *
     * @return Product
     */
    public function setStockMinimum($stockMinimum)
    {
        $this->stockMinimum = $stockMinimum;

        return $this;
    }

    /**
     * Get stockMinimum
     *
     * @return string
     */
    public function getStockMinimum()
    {
        return $this->stockMinimum;
    }

    /**
     * Set costMaximun
     *
     * @param string $costMaximum
     *
     * @return Product
     */
    public function setCostMaximum($costMaximum)
    {
        $this->costMaximum = $costMaximum;

        return $this;
    }

    /**
     * Get costMaximun
     *
     * @return string
     */
    public function getCostMaximum()
    {
        return $this->costMaximum;
    }

    /**
     * Set costMinimum
     *
     * @param string $costMinimum
     *
     * @return Product
     */
    public function setCostMinimum($costMinimum)
    {
        $this->costMinimum = $costMinimum;

        return $this;
    }

    /**
     * Get costMinimum
     *
     * @return string
     */
    public function getCostMinimum()
    {
        return $this->costMinimum;
    }

    /**
     * Set costAverage
     *
     * @param string $costAverage
     *
     * @return Product
     */
    public function setCostAverage($costAverage)
    {
        $this->costAverage = $costAverage;

        return $this;
    }

    /**
     * Get costAverage
     *
     * @return string
     */
    public function getCostAverage()
    {
        return $this->costAverage;
    }

    /**
     * Set stock
     *
     * @param string $stock
     *
     * @return Product
     */
    public function setStock($stock)
    {
        $this->stock = $stock;

        return $this;
    }

    /**
     * Get stock
     *
     * @return float
     */
    public function getStock()
    {
        return $this->stock;
    }


    /**
     * Set code
     *
     * @param string $code
     *
     * @return Product
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
     * @return ArrayCollection
     */
    public function getInventoryMovementDetails()
    {
        return $this->inventoryMovementDetails;
    }

    /**
     * @param ArrayCollection $inventoryMovementDetails
     */
    public function setInventoryMovementDetails($inventoryMovementDetails)
    {
        $this->inventoryMovementDetails = $inventoryMovementDetails;
    }

}
