<?php

namespace AppBundle\Controller\Product;

use AppBundle\Entity\Address;
use AppBundle\Entity\Product;
use Faker\Factory;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\ProductType;

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
        $products = $repository->findBy( array('addressId' => $address->getId()));

        $product = new Product();
        $product->setAddress($address);
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
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
     * Displays a form to edit an existing address entity.
     *
     * @Route("/{id}/edit", name="profile_edit")
     * @Method({"GET", "POST"})
     */
//    public function editAction(Request $request, Address $address)
//    {
//        $editForm = $this->createForm('AppBundle\Form\AddressType', $address);
//        $editForm->handleRequest($request);
//
//        if ($editForm->isSubmitted() && $editForm->isValid()) {
//            $this->getDoctrine()->getManager()->flush();
//
//            return $this->redirectToRoute('profile_index');
//        }
//
//        return $this->render('profile/edit.html.twig', array(
//            'shops' => $address,
//            'form' => $editForm->createView(),
//        ));
//    }
//
//
//    /**
//     * Deletes a address entity.
//     *
//     * @Route("/{id}", name="profile_delete")
//     * @Method({"GET", "POST"})
//     */
//    public function deleteAction(Request $request, Address $address)
//    {
//        $em = $this->getDoctrine()->getManager();
//        $em->remove($address);
//        $em->flush();
//        return $this->redirectToRoute('profile_index');
//    }



}
