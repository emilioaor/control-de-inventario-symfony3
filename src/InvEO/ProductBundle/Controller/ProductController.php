<?php

namespace InvEO\ProductBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use InvEO\ProductBundle\Entity\Product;
use Symfony\Component\HttpFoundation\Request;
use InvEO\CoreBundle\Model\Alert\Alert;

use InvEO\ProductBundle\Form\ProductType;

/**
 * Controlador de productos
 * @Route("/product")
 * @author Emilio Ochoa http://emilioochoa.com.ve
 */
class ProductController extends Controller
{

    /**
     * Carga summary de productos
     * @Route("/", name="product.index", methods="GET")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $products = $em->getRepository(Product::class)->findAll();

        return $this->render('ProductBundle:Product:index.html.twig', array(
            'products' => $products
        ));
    }

    /**
     * Carga formulario de registro de producto
     * @Route("/create", name="product.create")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createAction(Request $request)
    {
        /* @var $product Product */
        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository(Product::class)->getDefaultEntity();

        $form = $this->createForm(ProductType::class, $product, array(
            'action' => $this->generateUrl('product.create'),
            'method' => 'post',
        ));

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($product);
            $em->flush();

            Alert::alertSuccess(Alert::ALERT_REGISTER_SUCCESS);

            return $this->redirectToRoute('product.edit', array(
                'id' => $product->getId()
            ));

        } elseif ($form->isSubmitted() && ! $form->isValid()) {
            Alert::alertFail(Alert::ALERT_REGISTER_FAIL);
        }

        return $this->render('ProductBundle:Product:create.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * Vista con el detalle del producto
     * @Route("/{id}", name="product.show", methods="GET")
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository(Product::class)->find($id);

        return $this->render('ProductBundle:Product:show.html.twig', array(
            'product' => $product
        ));
    }

    /**
     * Actualiza el registro de un producto
     * @Route("/{id}/edit", name="product.edit")
     * @param $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function editAction($id, Request $request)
    {
        /* @var $product Product */
        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository(Product::class)->find($id);

        $form = $this->createForm(ProductType::class, $product, array(
            'action' => $this->generateUrl('product.edit', array('id' => $id)),
            'method' => 'post'
        ));

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->flush();
            Alert::alertSuccess(Alert::ALERT_UPDATE_SUCCESS);

            return $this->redirectToRoute('product.edit', array('id' => $id));

        } elseif ($form->isSubmitted() && ! $form->isValid()) {
            Alert::alertFail(Alert::ALERT_UPDATE_FAIL);
        }

        return $this->render('ProductBundle:Product:edit.html.twig', array(
            'form' => $form->createView(),
            'product' => $product
        ));

    }
}
