<?php

namespace InvEO\InventoryMovementBundle\Repository;

use InvEO\ClientAndSupplierBundle\Entity\ClientAndSupplier;
use InvEO\CoreBundle\Repository\BaseRepository;
use InvEO\InventoryMovementBundle\Entity\InventoryMovement;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\DateTime;
use InvEO\InventoryMovementBundle\Entity\Detail\InventoryMovementDetail;

/**
 * Class InventoryMovementRepository
 * @package InvEO\InventoryMovementBundle\Repository
 * @author Emilio Ochoa http://emilioochoa.com.ve
 */
class InventoryMovementRepository extends BaseRepository
{

    /**
     * Retorna entidad base
     * @return InventoryMovement
     */
    public function getDefaultEntity()
    {
        $movement = new InventoryMovement();
        $movement
            ->setDateIssue(new \DateTime('now'))
            ->setStatus(InventoryMovement::STATUS_PENDING)
        ;

        return $movement;
    }


    /**
     * Retorna todas las entradas
     * @param string $order
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function findAllInput($order = 'DESC')
    {
        $results = $this->createQueryBuilder('inp')
            ->select('inp.id, inp.code, inp.dateIssue, sup.name as supplierName, inp.status')
            ->join(ClientAndSupplier::class, 'sup', 'WITH', 'inp.fkClientAndSupplier = sup.id')
            ->where('inp.type = :type')
            ->setParameter('type', InventoryMovement::TYPE_INPUT)
            ->orderBy('inp.id', $order)
            ->getQuery()->getResult()
        ;

        return $results;
    }

    /**
     * Retorna todas las salidas
     * @param string $order
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function findAllOutput($order = 'DESC')
    {
        $results = $this->createQueryBuilder('out')
            ->select('out.id, out.code, out.dateIssue, cli.name as clientName, out.status')
            ->join(ClientAndSupplier::class, 'cli', 'WITH', 'out.fkClientAndSupplier = cli.id')
            ->where('out.type = :type')
            ->setParameter('type', InventoryMovement::TYPE_OUTPUT)
            ->orderBy('out.id', $order)
            ->getQuery()->getResult()
        ;

        return $results;
    }

    /**
     * Retorna entidad input por default
     * @return InventoryMovement
     * @throws \Exception
     */
    public function getDefaultEntityInput()
    {
        /* @var $input \InvEO\InventoryMovementBundle\Entity\InventoryMovement */
        $input = $this->getDefaultEntity();
        $input
            ->setCode($this->generateCode(InventoryMovement::INPUT_MASK))
            ->setMask(InventoryMovement::INPUT_MASK)
            ->setType(InventoryMovement::TYPE_INPUT)
        ;

        return $input;
    }

    /**
     * Retorna entidad output por default
     * @return InventoryMovement
     * @throws \Exception
     */
    public function getDefaultEntityOutput()
    {
        /* @var $output InventoryMovement */
        $output = $this->getDefaultEntity();
        $output
            ->setCode($this->generateCode(InventoryMovement::OUTPUT_MASK))
            ->setMask(InventoryMovement::OUTPUT_MASK)
            ->setType(InventoryMovement::TYPE_OUTPUT)
        ;

        return $output;
    }

    /**
     * Limpia todas las lineas de detalle para un movimiento
     * de inventario
     *
     * @param $fkInventoryMovement
     */
    public function clearDetail($fkInventoryMovement)
    {
        $this->getEntityManager()->createQueryBuilder()
            ->delete()
            ->from(InventoryMovementDetail::class, 'imd')
            ->where('imd.fkInventoryMovement = :fkInventoryMovement')
            ->setParameter('fkInventoryMovement', $fkInventoryMovement)
            ->getQuery()->getResult()
        ;
    }
}
