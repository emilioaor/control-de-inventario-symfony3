<?php
namespace InvEO\ClientAndSupplierBundle\Controller\Supplier;

use InvEO\CoreBundle\Model\Alert\Alert;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use InvEO\ClientAndSupplierBundle\Entity\ClientAndSupplier;
use Symfony\Component\HttpFoundation\Request;
use InvEO\ClientAndSupplierBundle\Form\ClientAndSupplierType;

/**
 * Controlador de proveedores
 *
 * Class ClientController
 *
 * @route("/supplier")
 * @package InvEO\ClientAndSupplierBundle\Controller\Supplier
 * @author Emilio Ochoa http://emilioochoa.com.ve
 */
class SupplierController extends Controller
{

    /**
     * Vista principal de provedores
     *
     * @route("/", name="supplier.index", methods="GET")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $suppliers = $em->getRepository(ClientAndSupplier::class)->findAllSupplier();

        return $this->render('ClientAndSupplierBundle:Supplier:index.html.twig', array(
            'suppliers' => $suppliers
        ));
    }

    /**
     * Registrar proveedor
     *
     * @route("/create", name="supplier.create")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createAction(Request $request)
    {
        /* @var $supplier \InvEO\ClientAndSupplierBundle\Entity\ClientAndSupplier */
        $em = $this->getDoctrine()->getManager();
        $supplier = $em->getRepository(ClientAndSupplier::class)->getDefaultSupplierEntity();

        $form = $this->createForm(ClientAndSupplierType::class, $supplier, array(
            'action' => $this->generateUrl('supplier.create'),
            'method' => 'post'
        ));

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($supplier);
            $em->flush();

            Alert::alertSuccess(Alert::ALERT_REGISTER_SUCCESS);

            return $this->redirectToRoute('supplier.edit', array('id' => $supplier->getId()));

        } elseif ($form->isSubmitted() && ! $form->isValid()) {
            Alert::alertFail(Alert::ALERT_REGISTER_FAIL);
        }

        return $this->render('ClientAndSupplierBundle:Supplier:create.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * Actualizar proveedor
     *
     * @route("/{id}/edit", name="supplier.edit")
     * @param $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $supplier = $em->getRepository(ClientAndSupplier::class)->find($id);

        $form = $this->createForm(ClientAndSupplierType::class, $supplier, array(
            'action' => $this->generateUrl('supplier.edit', array('id' => $id)),
            'method' => 'post'
        ));

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->flush();
            Alert::alertSuccess(Alert::ALERT_UPDATE_SUCCESS);

            return $this->redirectToRoute('supplier.edit', array('id' => $id));

        } elseif ($form->isSubmitted() && ! $form->isValid()) {
            Alert::alertFail(Alert::ALERT_UPDATE_FAIL);
        }

        return $this->render('ClientAndSupplierBundle:Supplier:edit.html.twig', array(
            'form' => $form->createView(),
            'supplier' => $supplier
        ));
    }

    /**
     * Vista de detalle del proveedor
     *
     * @route("/{id}", name="supplier.show", methods="GET")
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $supplier = $em->getRepository(ClientAndSupplier::class)->find($id);

        return $this->render('ClientAndSupplierBundle:Supplier:show.html.twig', array(
            'supplier' => $supplier
        ));
    }
}