<?php
namespace InvEO\ClientAndSupplierBundle\Controller\Client;

use InvEO\CoreBundle\Model\Alert\Alert;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use InvEO\ClientAndSupplierBundle\Entity\ClientAndSupplier;
use Symfony\Component\HttpFoundation\Request;
use InvEO\ClientAndSupplierBundle\Form\ClientAndSupplierType;

/**
 * Controlador de clientes
 *
 * Class ClientController
 *
 * @route("/client")
 * @package InvEO\ClientAndSupplierBundle\Controller\Client
 * @author Emilio Ochoa http://emilioochoa.com.ve
 */
class ClientController extends Controller
{

    /**
     * Vista principal de clientes
     *
     * @route("/", name="client.index", methods="GET")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $clients = $em->getRepository(ClientAndSupplier::class)->findAllClient();

        return $this->render('ClientAndSupplierBundle:Client:index.html.twig', array(
            'clients' => $clients
        ));
    }

    /**
     * Registrar cliente
     *
     * @route("/create", name="client.create")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createAction(Request $request)
    {
        /* @var $client \InvEO\ClientAndSupplierBundle\Entity\ClientAndSupplier */
        $em = $this->getDoctrine()->getManager();
        $client = $em->getRepository(ClientAndSupplier::class)->getDefaultClientEntity();

        $form = $this->createForm(ClientAndSupplierType::class, $client, array(
            'action' => $this->generateUrl('client.create'),
            'method' => 'post'
        ));

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($client);
            $em->flush();

            Alert::alertSuccess(Alert::ALERT_REGISTER_SUCCESS);

            return $this->redirectToRoute('client.edit', array('id' => $client->getId()));

        } elseif ($form->isSubmitted() && ! $form->isValid()) {
            Alert::alertFail(Alert::ALERT_REGISTER_FAIL);
        }

        return $this->render('ClientAndSupplierBundle:Client:create.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * Actualizar cliente
     *
     * @route("/{id}/edit", name="client.edit")
     * @param $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $client = $em->getRepository(ClientAndSupplier::class)->find($id);

        $form = $this->createForm(ClientAndSupplierType::class, $client, array(
            'action' => $this->generateUrl('client.edit', array('id' => $id)),
            'method' => 'post'
        ));

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->flush();
            Alert::alertSuccess(Alert::ALERT_UPDATE_SUCCESS);

            return $this->redirectToRoute('client.edit', array('id' => $id));

        } elseif ($form->isSubmitted() && ! $form->isValid()) {
            Alert::alertFail(Alert::ALERT_UPDATE_FAIL);
        }

        return $this->render('ClientAndSupplierBundle:Client:edit.html.twig', array(
            'form' => $form->createView(),
            'client' => $client
        ));
    }

    /**
     * Vista de detalle del cliente
     *
     * @route("/{id}", name="client.show", methods="GET")
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $client = $em->getRepository(ClientAndSupplier::class)->find($id);

        return $this->render('ClientAndSupplierBundle:Client:show.html.twig', array(
            'client' => $client
        ));
    }
}