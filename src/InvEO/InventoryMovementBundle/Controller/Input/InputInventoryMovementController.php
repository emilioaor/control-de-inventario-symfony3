<?php

namespace InvEO\InventoryMovementBundle\Controller\Input;

use InvEO\ClientAndSupplierBundle\Entity\ClientAndSupplier;
use InvEO\CoreBundle\Model\Alert\Alert;
use InvEO\ProductBundle\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use InvEO\InventoryMovementBundle\Entity\InventoryMovement;
use InvEO\InventoryMovementBundle\Form\InventoryMovementType;
use Symfony\Component\HttpFoundation\Request;
use InvEO\InventoryMovementBundle\Form\Detail\InventoryMovementDetailType;
use InvEO\InventoryMovementBundle\Entity\Detail\InventoryMovementDetail;

/**
 * Controlador de entradas de inventario
 *
 * @route("/input")
 * @author Emilio Ochoa http://emilioochoa.com.ve
 */
class InputInventoryMovementController extends Controller
{

    /**
     * Carga vista principal de entradas de inventario
     *
     * @route("/", name="input.index", methods="GET")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $inputs = $em->getRepository(InventoryMovement::class)->findAllInput();

        return $this->render('InventoryMovementBundle:Input:index.html.twig', array(
            'inputs' => $inputs
        ));
    }

    /**
     * Registrar entrada
     *
     * @route("/create", name="input.create")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createAction(Request $request)
    {
        /* @var $input InventoryMovement */
        $em = $this->getDoctrine()->getManager();
        $input = $em->getRepository(InventoryMovement::class)->getDefaultEntityInput();

        $form = $this->createForm(InventoryMovementType::class, $input, array(
            'action' => $this->generateUrl('input.create'),
            'method' => 'post',
            'clientAndSupplierChoices' => $em->getRepository(ClientAndSupplier::class)->getChoicesSupplier()
        ));

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $supplier = $em->getRepository(ClientAndSupplier::class)->find($input->getFkClientAndSupplier());
            $input->setClientAndSupplier($supplier);

            $em->persist($input);
            $em->flush();

            Alert::alertSuccess(Alert::ALERT_REGISTER_SUCCESS);

            return $this->redirectToRoute('input.edit', array('id' => $input->getId()));

        } elseif ($form->isSubmitted()) {
            Alert::alertFail(Alert::ALERT_REGISTER_FAIL);
        }

        return $this->render('InventoryMovementBundle:Input:create.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * Detalle de entrada de inventario
     *
     * @route("/{id}", name="input.show")
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $input = $em->getRepository(InventoryMovement::class)->find($id);

        return $this->render('InventoryMovementBundle:Input:show.html.twig', array(
            'input' => $input
        ));
    }

    /**
     * Actualizar entrada
     *
     * @route("/{id}/edit", name="input.edit")
     * @param $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction($id, Request $request)
    {
        /* @var $input InventoryMovement */
        $em = $this->getDoctrine()->getManager();
        $input = $em->getRepository(InventoryMovement::class)->find($id);
        $products = $em->getRepository(Product::class)->findAll();

        $form = $this->createForm(InventoryMovementType::class, $input, array(
            'action' => $this->generateUrl('input.edit', array('id' => $id)),
            'method' => 'post',
            'clientAndSupplierChoices' => $em->getRepository(ClientAndSupplier::class)->getChoicesSupplier()
        ));

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->getRepository(InventoryMovement::class)->clearDetail($input->getId());

            $details = ! is_null($request->get('detail')) ? $request->get('detail') : array();

            foreach ($details as $detail) {

                $movementDetail = new InventoryMovementDetail();
                $movementDetail
                    ->setProduct($em->getRepository(Product::class)->find($detail['productId']))
                    ->setCost($detail['cost'])
                    ->setQuantity($detail['quantity'])
                    ->setTotal($detail['cost'] * $detail['quantity'])
                    ->setInventoryMovement($input)
                ;

                $em->persist($movementDetail);
            }

            $em->flush();
            Alert::alertSuccess(Alert::ALERT_UPDATE_SUCCESS);

            return $this->redirectToRoute('input.edit', array('id' => $id));

        } elseif ($form->isSubmitted()) {
            Alert::alertFail(Alert::ALERT_UPDATE_FAIL);
        }

        return $this->render('InventoryMovementBundle:Input:edit.html.twig', array(
            'form' => $form->createView(),
            'input' => $input,
            'products' => $products
        ));
    }

    /**
     *Valida la entrada en inventario
     *
     * @route("/{id}/validate", name="input.validate", methods="GET")
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function validateAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $em->beginTransaction();

        /* @var $input InventoryMovement */
        $input = $em->getRepository(InventoryMovement::class)->find($id);
        $input->setStatus(InventoryMovement::STATUS_VALIDATED);

        /* @var $detail InventoryMovementDetail */
        foreach ($input->getDetails() as $detail) {

            $product = $detail->getProduct();
            $product->setStock( $product->getStock() + $detail->getQuantity() );

            if ($product->getCostMinimum() == 0 || $detail->getCost() < $product->getCostMinimum()) {
                $product->setCostMinimum($detail->getCost());
            }

            if ($detail->getCost() > $product->getCostMaximum()) {
                $product->setCostMaximum($detail->getCost());
            }

            $em->flush();

            $average = $em->getRepository(Product::class)->calculateCostAverage($product->getId());
            $product->setCostAverage($average);

        }

        $em->flush();
        $em->commit();

        Alert::alertSuccess(Alert::ALERT_VALIDATE_SUCCESS);

        return $this->redirectToRoute('input.show', array('id' => $id));
    }
}