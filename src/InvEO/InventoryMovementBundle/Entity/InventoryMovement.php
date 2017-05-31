<?php

namespace InvEO\InventoryMovementBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use InvEO\CoreBundle\Entity\BaseEntity;
use Doctrine\Common\Collections\ArrayCollection;
use InvEO\CoreBundle\Model\Icons\Icon;

/**
 * InventoryMovement
 *
 * @ORM\Table(name="inventory_movement")
 * @ORM\Entity(repositoryClass="InvEO\InventoryMovementBundle\Repository\InventoryMovementRepository")
 * @author Emilio Ochoa http://emilioochoa.com.ve
 */
class InventoryMovement extends BaseEntity
{
    /** Movements types  */
    const TYPE_INPUT = 'TypeInput';
    const TYPE_OUTPUT = 'TypeOutput';
    /** Masks */
    const INPUT_MASK = '{ENT}{000000}';
    const OUTPUT_MASK = '{SAL}{000000}';
    /** Status */
    const STATUS_PENDING = 0;
    const STATUS_VALIDATED = 1;

    /**
     * @var string
     *
     * @ORM\Column(name="code", type="string", length=20, unique=true)
     */
    private $code;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateIssue", type="datetime", nullable=true)
     */
    private $dateIssue;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=20)
     */
    private $type;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="status", type="integer")
     */
    private $status;

    /**
     * @var integer
     *
     * @ORM\Column(name="fk_client_and_supplier", type="integer")
     */
    private $fkClientAndSupplier;

    /**
     * @var
     *
     * @ORM\ManyToOne(targetEntity="InvEO\ClientAndSupplierBundle\Entity\ClientAndSupplier", inversedBy="inventoryMovements")
     * @ORM\JoinColumn(name="fk_client_and_supplier", referencedColumnName="id")
     */
    private $clientAndSupplier;

    /**
     * @var ArrayCollection<InvEO\InventoryMovementBundle\Entity\Detail\InventoryMovementDetail>
     *
     * @ORM\OneToMany(targetEntity="InvEO\InventoryMovementBundle\Entity\Detail\InventoryMovementDetail", mappedBy="inventoryMovement")
     */
    private $details;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->statusHtml = '<span class="' . Icon::ICON_VALIDATE . '"></span>';

        $this->details = new ArrayCollection();
    }

    /**
     * Set code
     *
     * @param string $code
     *
     * @return InventoryMovement
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
     * Set dateIssue
     *
     * @param \DateTime $dateIssue
     *
     * @return InventoryMovement
     */
    public function setDateIssue($dateIssue)
    {
        $this->dateIssue = $dateIssue;

        return $this;
    }

    /**
     * Get dateIssue
     *
     * @return \DateTime
     */
    public function getDateIssue()
    {
        return $this->dateIssue;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return InventoryMovement
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set status
     *
     * @param integer $status
     *
     * @return InventoryMovement
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return integer
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set fkClientAndSupplier
     *
     * @param integer $fkClientAndSupplier
     *
     * @return InventoryMovement
     */
    public function setFkClientAndSupplier($fkClientAndSupplier)
    {
        $this->fkClientAndSupplier = $fkClientAndSupplier;

        return $this;
    }

    /**
     * Get fkClientAndSupplier
     *
     * @return integer
     */
    public function getFkClientAndSupplier()
    {
        return $this->fkClientAndSupplier;
    }

    /**
     * Set clientAndSupplier
     *
     * @param \InvEO\ClientAndSupplierBundle\Entity\ClientAndSupplier $clientAndSupplier
     *
     * @return InventoryMovement
     */
    public function setClientAndSupplier(\InvEO\ClientAndSupplierBundle\Entity\ClientAndSupplier $clientAndSupplier = null)
    {
        $this->clientAndSupplier = $clientAndSupplier;

        return $this;
    }

    /**
     * Get clientAndSupplier
     *
     * @return \InvEO\ClientAndSupplierBundle\Entity\ClientAndSupplier
     */
    public function getClientAndSupplier()
    {
        return $this->clientAndSupplier;
    }

    /**
     * Add detail
     *
     * @param \InvEO\InventoryMovementBundle\Entity\Detail\InventoryMovementDetail $detail
     *
     * @return InventoryMovement
     */
    public function addDetail(\InvEO\InventoryMovementBundle\Entity\Detail\InventoryMovementDetail $detail)
    {
        $this->details[] = $detail;

        return $this;
    }

    /**
     * Remove detail
     *
     * @param \InvEO\InventoryMovementBundle\Entity\Detail\InventoryMovementDetail $detail
     */
    public function removeDetail(\InvEO\InventoryMovementBundle\Entity\Detail\InventoryMovementDetail $detail)
    {
        $this->details->removeElement($detail);
    }

    /**
     * Get details
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDetails()
    {
        return $this->details;
    }

}
