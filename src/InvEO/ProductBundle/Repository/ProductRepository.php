<?php

namespace InvEO\ProductBundle\Repository;

use InvEO\CoreBundle\Repository\BaseRepository;
use InvEO\ProductBundle\Entity\Product;
use InvEO\InventoryMovementBundle\Entity\Detail\InventoryMovementDetail;
use InvEO\InventoryMovementBundle\Entity\InventoryMovement;

/**
 * ProductRepository
 * @author Emilio Ochoa http://emilioochoa.com.ve
 */
class ProductRepository extends BaseRepository
{

    /**
     * Entidad por default para producto
     * @return Product
     */
    public function getDefaultEntity()
    {
        $entity = new Product();
        $entity
            ->setCode($this->generateCode(Product::MASK))
            ->setCostMaximum(0)
            ->setCostMinimum(0)
            ->setCostAverage(0)
            ->setStock(0)
            ->setMask(Product::MASK)
        ;

        return $entity;
    }

    /**
     * Retorna array con todos los productos
     * @param string $order
     * @return array
     */
    public function findAll($order = 'DESC')
    {

        $products = $this->createQueryBuilder('p')
            ->addSelect('p')
            ->orderBy('p.id', $order)
            ->getQuery()->getResult()
        ;

        return $products;
    }

    /**
     * Retorna choices de productos
     *
     * @return array
     */
    public function getProductChoices()
    {
        $choices = array();

        $results = $this->createQueryBuilder('p')
            ->select('p.id, p.name')
            ->getQuery()->getResult()
        ;

        foreach ($results as $product) {
            $choices[$product['name']] = $product['id'];
        }

        return $choices;
    }

    /**
     * Calcula el costo promedio para el producto especificado
     *
     * @param $fkProduct
     * @return mixed
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function calculateCostAverage($fkProduct)
    {
        $average = $this->getEntityManager()->createQueryBuilder()
            ->select('AVG(imd.cost)')
            ->from(InventoryMovementDetail::class, 'imd')
            ->join(InventoryMovement::class, 'im', 'WITH', 'imd.fkInventoryMovement = im.id')
            ->where('imd.fkProduct = :fkProduct')->setParameter('fkProduct', $fkProduct)
            ->andWhere('im.status = :status')->setParameter('status', InventoryMovement::STATUS_VALIDATED)
            ->getQuery()->getSingleScalarResult()
        ;

        return $average;
    }
}
