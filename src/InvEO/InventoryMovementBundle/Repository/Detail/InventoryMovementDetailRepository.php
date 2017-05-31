<?php

namespace InvEO\InventoryMovementBundle\Repository\Detail;

use InvEO\CoreBundle\Repository\BaseRepository;
use InvEO\InventoryMovementBundle\Entity\Detail\InventoryMovementDetail;

/**
 * Repositorio de inventoryMovementDetail
 *
 * @author Emilio Ochoa http://emilioochoa.com.ve
 */
class InventoryMovementDetailRepository extends BaseRepository
{

    /**
     * Retorna entidad por defecto para detalle de movimiento de inventario
     *
     * @return InventoryMovementDetail
     */
    public function getDefaultEntity()
    {
        $entity = new InventoryMovementDetail();
        $entity
            ->setQuantity(0)
            ->setCost(0)
            ->setTotal(0)
        ;

        return $entity;
    }
}
