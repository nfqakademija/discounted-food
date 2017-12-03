<?php

namespace AppBundle\Controller\Product;

use AppBundle\Entity\Address;
use AppBundle\Entity\Product;
use AppBundle\Form\ProductType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/profile/item", name="profile")
 */
class ProductController extends Controller
{

    /**
     *
     * @Route("/{id}/show", name="profile_item_show")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, Address $address)
    {
        $em = $this->getDoctrine()->getManager();

        $repository = $em->getRepository('AppBundle:Product');
        $products = $repository->findBy(array('addressId' => $address->getId()));

        $product = new Product();
        $product->setAddress($address);
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
//            var_dump($form->getData());die;
            $em->persist($form->getData());
            $em->flush();
            $this->addFlash(
                'notice',
                'New product added!'
            );
            return $this->redirect($request->getUri());
        }

        return $this->render('Product/index.html.twig', array(
            'shops' => $address,
            'products' => $products,
            'form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing product entity.
     *
     * @Route("/{id}/edit", name="product_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Product $product)
    {
        $editForm = $this->createForm('AppBundle\Form\ProductType', $product);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->addFlash(
                'notice',
                'Product updated!'
            );
            $this->getDoctrine()->getManager()->flush();
        }

        return $this->render('Product/edit.html.twig', array(
            'product' => $product,
            'form' => $editForm->createView(),
        ));
    }


    /**
     * Deletes a product entity.
     *
     * @Route("/{id}", name="product_delete")
     * @Method({"GET", "POST"})
     */
    public function deleteAction(Request $request, Product $product)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($product);
        $em->flush();
        return $this->redirectToRoute('profile_index');
    }
}
