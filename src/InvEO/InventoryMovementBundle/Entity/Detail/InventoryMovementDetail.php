<?php

namespace InvEO\InventoryMovementBundle\Entity\Detail;

use Doctrine\ORM\Mapping as ORM;

/**
 * InventoryMovementDetail
 *
 * @ORM\Table(name="inventory_movement_detail")
 * @ORM\Entity(repositoryClass="InvEO\InventoryMovementBundle\Repository\Detail\InventoryMovementDetailRepository")
 * @author Emilio Ochoa http://emilioochoa.com.ve
 */
class InventoryMovementDetail
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="fk_inventory_movement", type="integer")
     */
    private $fkInventoryMovement;

    /**
     * @var \InvEO\InventoryMovementBundle\Entity\InventoryMovement
     *
     * @ORM\ManyToOne(targetEntity="InvEO\InventoryMovementBundle\Entity\InventoryMovement", inversedBy="details")
     * @ORM\JoinColumn(name="fk_inventory_movement", referencedColumnName="id")
     */
    private $inventoryMovement;

    /**
     * @var int
     *
     * @ORM\Column(name="fk_product", type="integer")
     */
    private $fkProduct;

    /**
     * @var \InvEO\ProductBundle\Entity\Product
     *
     * @ORM\ManyToOne(targetEntity="InvEO\ProductBundle\Entity\Product", inversedBy="inventoryMovementDetails")
     * @ORM\JoinColumn(name="fk_product", referencedColumnName="id")
     */
    private $product;

    /**
     * @var float
     *
     * @ORM\Column(name="quantity", type="decimal", precision=10, scale=2)
     */
    private $quantity;

    /**
     * @var float
     *
     * @ORM\Column(name="cost", type="decimal", precision=10, scale=2)
     */
    private $cost;

    /**
     * @var float
     *
     * @ORM\Column(name="total", type="decimal", precision=10, scale=2)
     */
    private $total;


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
     * Set fkInventoryMovement
     *
     * @param integer $fkInventoryMovement
     *
     * @return InventoryMovementDetail
     */
    public function setFkInventoryMovement($fkInventoryMovement)
    {
        $this->fkInventoryMovement = $fkInventoryMovement;

        return $this;
    }

    /**
     * Get fkInventoryMovement
     *
     * @return int
     */
    public function getFkInventoryMovement()
    {
        return $this->fkInventoryMovement;
    }

    /**
     * Set fkProduct
     *
     * @param integer $fkProduct
     *
     * @return InventoryMovementDetail
     */
    public function setFkProduct($fkProduct)
    {
        $this->fkProduct = $fkProduct;

        return $this;
    }

    /**
     * Get fkProduct
     *
     * @return int
     */
    public function getFkProduct()
    {
        return $this->fkProduct;
    }

    /**
     * Set quantity
     *
     * @param float $quantity
     *
     * @return InventoryMovementDetail
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return float
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set cost
     *
     * @param float $cost
     *
     * @return InventoryMovementDetail
     */
    public function setCost($cost)
    {
        $this->cost = $cost;

        return $this;
    }

    /**
     * Get cost
     *
     * @return float
     */
    public function getCost()
    {
        return $this->cost;
    }

    /**
     * @return \InvEO\InventoryMovementBundle\Entity\InventoryMovement
     */
    public function getInventoryMovement()
    {
        return $this->inventoryMovement;
    }

    /**
     * @param \InvEO\InventoryMovementBundle\Entity\InventoryMovement $inventoryMovement
     */
    public function setInventoryMovement($inventoryMovement)
    {
        $this->inventoryMovement = $inventoryMovement;
    }

    /**
     * @return \InvEO\ProductBundle\Entity\Product
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * @param \InvEO\ProductBundle\Entity\Product $product
     * @return InventoryMovementDetail
     */
    public function setProduct($product)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * @return float
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * @param float $total
     * @return InventoryMovementDetail
     */
    public function setTotal($total)
    {
        $this->total = $total;

        return $this;
    }


}

