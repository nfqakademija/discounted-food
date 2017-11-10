<?php

namespace AppBundle\Controller\Profile;

use AppBundle\Entity\Address;
use Faker\Factory;
use Ivory\GoogleMap\Base\Coordinate;
use Ivory\GoogleMap\Map;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\AddressType;

/**
 * @Route("/profile", name="profile")
 */
class ProfileController extends Controller
{

    /**
     * Creates a new address entity.
     *
     * @Route("/", name="profile_index")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $address_repository = $em->getRepository('AppBundle:Address');
        $addresses = $address_repository->findBy(array('shop_owner' => $this->getUser()->getId()));

        $address = new Address();
        $address->setShopOwner($this->getUser());
        $form = $this->createForm(AddressType::class, $address);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($address);
            $em->flush();

            $this->addFlash(
                'notice',
                'New shop added!'
            );

            return $this->redirectToRoute('profile_index', array('id' => $address->getId()));
        }

        $map = new Map();

        $map->setStylesheetOption('height', '400px');
        $map->setStylesheetOption('width', '100%');
        $map->setMapOption('zoom', 12);
        $map->setCenter(new Coordinate(54.687157, 25.279652));

        return $this->render('Profile/profile.html.twig', array(
            'shops' => $addresses,
            'form' => $form->createView(),
            'map'  => $map
        ));
    }

    /**
     * Displays a form to edit an existing address entity.
     *
     * @Route("/{id}/edit", name="profile_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Address $address)
    {
        $editForm = $this->createForm('AppBundle\Form\AddressType', $address);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash(
                'notice',
                'Shop updated!'
            );

            return $this->redirectToRoute('profile_index');
        }

        return $this->render('Profile/edit.html.twig', array(
            'shops' => $address,
            'form' => $editForm->createView(),
        ));
    }


    /**
     * Deletes a address entity.
     *
     * @Route("/{id}", name="profile_delete")
     * @Method({"GET", "POST"})
     */
    public function deleteAction(Request $request, Address $address)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($address);
        $em->flush();

        $this->addFlash(
            'notice',
            'Shop deleted!'
        );
        return $this->redirectToRoute('profile_index');
    }



}
