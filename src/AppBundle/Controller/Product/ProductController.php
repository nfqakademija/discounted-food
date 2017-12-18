<?php

namespace AppBundle\Controller\Product;

use AppBundle\Entity\Address;
use AppBundle\Entity\Product;
use AppBundle\Entity\Subscribe;
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
    public function newAction(Request $request, Address $address, \Swift_Mailer $mailer)
    {
        $em = $this->getDoctrine()->getManager();

        $repository = $em->getRepository('AppBundle:Product');
        $products = $repository->findBy(array('addressId' => $address->getId()));

        $product = new Product();
        $product->setAddress($address);
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($form->getData());
            $em->flush();

            $repository = $em->getRepository(Subscribe::class);

            $emails = $repository->findAll();

            foreach ($emails as $email) {
                $message = (new \Swift_Message('New food offer for you!'))
                    ->setFrom('noreply@discountedfood.com')
                    ->setTo($email->getEmail())
                    ->setBody($product->getName());


                $mailer->send($message);

            }

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
        $authUserId = $this->getUser()->getId();

        $productOwnerId = $product->getAddress()->getShopOwner()->getId();

        if ($authUserId === $productOwnerId) {
            $editForm = $this->createForm('AppBundle\Form\ProductType', $product);
            $editForm->handleRequest($request);

            if ($editForm->isSubmitted() && $editForm->isValid()) {
                $this->addFlash(
                    'notice',
                    'Product updated!'
                );
                $this->getDoctrine()->getManager()->flush();
                return $this->redirectToRoute('profile_item_show', array('id' => $product->getId()));
            }

            return $this->render('Product/edit.html.twig', array(
                'product' => $product,
                'form' => $editForm->createView(),
            ));
        } else {
            throw $this->createNotFoundException('Unauthorized action');
        }
    }


    /**
     * Deletes a product entity.
     *
     * @Route("/{id}", name="product_delete")
     * @Method({"GET", "POST"})
     */
    public function deleteAction(Request $request, Product $product)
    {
        $authUserId = $this->getUser()->getId();

        $productOwnerId = $product->getAddress()->getShopOwner()->getId();

        if ($authUserId === $productOwnerId) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($product);
            $em->flush();
            return $this->redirectToRoute('profile_index');
        } else {
            throw $this->createNotFoundException('Unauthorized action');
        }
    }
}
