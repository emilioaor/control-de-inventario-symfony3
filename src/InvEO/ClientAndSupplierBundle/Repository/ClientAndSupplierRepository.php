<?php

namespace InvEO\ClientAndSupplierBundle\Repository;

use InvEO\CoreBundle\Repository\BaseRepository;
use InvEO\ClientAndSupplierBundle\Entity\ClientAndSupplier;

/**
 * ClientAndSupplierRepository
 *
 * @author Emilio Ochoa http://emilioochoa.com.ve
 */
class ClientAndSupplierRepository extends BaseRepository
{
    /**
     * retorna entidad base
     */
    public function getDefaultEntity()
    {
        $entity = new ClientAndSupplier();

        return $entity;
    }

    /**
     * Retorna entidad de cliente
     */
    public function getDefaultClientEntity()
    {
        /* @var $entity \InvEO\ClientAndSupplierBundle\Entity\ClientAndSupplier */
        $entity = $this->getDefaultEntity();
        $entity
            ->setCode($this->generateCode(ClientAndSupplier::CLIENT_MASK))
            ->setClientActive(ClientAndSupplier::CLIENT_ACTIVE)
            ->setSupplierActive(ClientAndSupplier::SUPPLIER_INACTIVE)
            ->setMask(ClientAndSupplier::CLIENT_MASK)
        ;

        return $entity;
    }

    /**
     * Retorna entidad de proveedor
     */
    public function getDefaultSupplierEntity()
    {
        /* @var $entity \InvEO\ClientAndSupplierBundle\Entity\ClientAndSupplier */
        $entity = $this->getDefaultEntity();
        $entity
            ->setCode($this->generateCode(ClientAndSupplier::SUPPLIER_MASK))
            ->setClientActive(ClientAndSupplier::CLIENT_INACTIVE)
            ->setSupplierActive(ClientAndSupplier::SUPPLIER_ACTIVE)
            ->setMask(ClientAndSupplier::SUPPLIER_MASK)
        ;

        return $entity;
    }

    /**
     * Retorna todos los clientes
     * @param string $order
     * @return array
     */
    public function findAllClient($order = 'DESC')
    {
        $clients = $this->createQueryBuilder('c')
            ->addSelect('c')
            ->where('c.clientActive = :clientActive')
            ->setParameter('clientActive', ClientAndSupplier::CLIENT_ACTIVE)
            ->orderBy('c.id', $order)
            ->getQuery()->getResult()
        ;

        return $clients;
    }

    /**
     * Retorna todos los proveedores
     * @param string $order
     * @return array
     */
    public function findAllSupplier($order = 'DESC')
    {
        $suppliers = $this->createQueryBuilder('c')
            ->addSelect('c')
            ->where('c.supplierActive = :supplierActive')
            ->setParameter('supplierActive', ClientAndSupplier::SUPPLIER_ACTIVE)
            ->orderBy('c.id', $order)
            ->getQuery()->getResult()
        ;

        return $suppliers;
    }

    /**
     * Retorna choices de proveedores
     *
     * @return array
     */
    public function getChoicesSupplier()
    {
        $choices = array();

        $results = $this->createQueryBuilder('sup')
            ->select('sup.id, sup.name')
            ->where('sup.supplierActive = :supplierActive')
            ->setParameter('supplierActive', ClientAndSupplier::SUPPLIER_ACTIVE)
            ->getQuery()->getResult()
        ;

        foreach ($results as $supplier) {
            $choices[$supplier['name']] = $supplier['id'];
        }

        return $choices;
    }

    /**
     * Retorna choices de clientes
     *
     * @return array
     */
    public function getChoicesClient()
    {
        $choices = array();

        $results = $this->createQueryBuilder('cli')
            ->select('cli.id, cli.name')
            ->where('cli.clientActive = :clientActive')
            ->setParameter('clientActive', ClientAndSupplier::CLIENT_ACTIVE)
            ->getQuery()->getResult()
        ;

        foreach ($results as $client) {
            $choices[$client['name']] = $client['id'];
        }

        return $choices;
    }
}
