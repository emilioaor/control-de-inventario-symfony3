<?php

namespace InvEO\InventoryMovementBundle\Controller\Output;

use InvEO\ClientAndSupplierBundle\Entity\ClientAndSupplier;
use InvEO\CoreBundle\Model\Alert\Alert;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use InvEO\InventoryMovementBundle\Entity\InventoryMovement;
use InvEO\InventoryMovementBundle\Entity\Detail\InventoryMovementDetail;
use InvEO\InventoryMovementBundle\Form\InventoryMovementType;
use Symfony\Component\HttpFoundation\Request;

use InvEO\ProductBundle\Entity\Product;


/**
 * Controlador de salidas de inventario
 *
 * @route("/output")
 * @author Emilio Ochoa http://emilioochoa.com.ve
 */
class OutputInventoryMovementController extends Controller
{

    /**
     * Carga vista principal de salidas de inventario
     *
     * @route("/", name="output.index", methods="GET")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $outputs = $em->getRepository(InventoryMovement::class)->findAllOutput();

        return $this->render('InventoryMovementBundle:Output:index.html.twig', array(
            'outputs' => $outputs
        ));
    }

    /**
     * Registrar salida
     *
     * @route("/create", name="output.create")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createAction(Request $request)
    {
        /* @var $output InventoryMovement */
        $em = $this->getDoctrine()->getManager();
        $output = $em->getRepository(InventoryMovement::class)->getDefaultEntityOutput();

        $form = $this->createForm(InventoryMovementType::class, $output, array(
            'action' => $this->generateUrl('output.create'),
            'method' => 'post',
            'clientAndSupplierChoices' => $em->getRepository(ClientAndSupplier::class)->getChoicesClient()
        ));

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $supplier = $em->getRepository(ClientAndSupplier::class)->find($output->getFkClientAndSupplier());
            $output->setClientAndSupplier($supplier);

            $em->persist($output);
            $em->flush();

            Alert::alertSuccess(Alert::ALERT_REGISTER_SUCCESS);

            return $this->redirectToRoute('output.edit', array('id' => $output->getId()));

        } elseif ($form->isSubmitted()) {
            Alert::alertFail(Alert::ALERT_REGISTER_FAIL);
        }

        return $this->render('InventoryMovementBundle:Output:create.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * Detalle de salida de inventario
     *
     * @route("/{id}", name="output.show")
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $output = $em->getRepository(InventoryMovement::class)->find($id);

        return $this->render('InventoryMovementBundle:Output:show.html.twig', array(
            'output' => $output
        ));
    }

    /**
     * Actualizar salida
     *
     * @route("/{id}/edit", name="output.edit")
     * @param $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction($id, Request $request)
    {
        /* @var $output InventoryMovement */
        $em = $this->getDoctrine()->getManager();
        $output = $em->getRepository(InventoryMovement::class)->find($id);
        $products = $em->getRepository(Product::class)->findAll();

        $form = $this->createForm(InventoryMovementType::class, $output, array(
            'action' => $this->generateUrl('output.edit', array('id' => $id)),
            'method' => 'post',
            'clientAndSupplierChoices' => $em->getRepository(ClientAndSupplier::class)->getChoicesClient()
        ));

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->getRepository(InventoryMovement::class)->clearDetail($output->getId());

            $details = ! is_null($request->get('detail')) ? $request->get('detail') : array();

            foreach ($details as $detail) {

                $movementDetail = new InventoryMovementDetail();
                $movementDetail
                    ->setProduct($em->getRepository(Product::class)->find($detail['productId']))
                    ->setCost($detail['cost'])
                    ->setQuantity($detail['quantity'])
                    ->setTotal($detail['cost'] * $detail['quantity'])
                    ->setInventoryMovement($output)
                ;

                $em->persist($movementDetail);
            }

            $em->flush();
            Alert::alertSuccess(Alert::ALERT_UPDATE_SUCCESS);

            return $this->redirectToRoute('output.edit', array('id' => $id));

        } elseif ($form->isSubmitted()) {
            Alert::alertFail(Alert::ALERT_UPDATE_FAIL);
        }

        return $this->render('InventoryMovementBundle:Output:edit.html.twig', array(
            'form' => $form->createView(),
            'output' => $output,
            'products' => $products
        ));
    }

    /**
     *Valida la salida en inventario
     *
     * @route("/{id}/validate", name="output.validate", methods="GET")
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function validateAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $em->beginTransaction();

        /* @var $output InventoryMovement */
        $output = $em->getRepository(InventoryMovement::class)->find($id);
        $output->setStatus(InventoryMovement::STATUS_VALIDATED);

        /* @var $detail InventoryMovementDetail */
        foreach ($output->getDetails() as $detail) {

            $product = $detail->getProduct();

            if ($detail->getQuantity() > $product->getStock()) {
                $em->rollback();
                Alert::alertFail('El producto: "' . $product->getName() . '" solo posee ' . $product->getStock() . ' en stock');

                return $this->redirectToRoute('output.edit', array('id' => $id));
            }

            $product->setStock( $product->getStock() - $detail->getQuantity() );

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

        return $this->redirectToRoute('output.show', array('id' => $id));
    }
}