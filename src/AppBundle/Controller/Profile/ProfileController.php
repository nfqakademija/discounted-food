<?php

namespace AppBundle\Controller\Profile;

use AppBundle\Entity\Address;
use AppBundle\Form\AddressType;
use Http\Adapter\Guzzle6\Client;
use Http\Message\MessageFactory\GuzzleMessageFactory;
use Ivory\GoogleMap\Helper\Builder\ApiHelperBuilder;
use Ivory\GoogleMap\Helper\Builder\PlaceAutocompleteHelperBuilder;
use Ivory\GoogleMap\Place\Autocomplete;
use Ivory\GoogleMap\Service\Geocoder\GeocoderService;
use Ivory\GoogleMap\Service\Geocoder\Request\GeocoderAddressRequest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

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
            $geocoder = new GeocoderService(new Client(), new GuzzleMessageFactory());
            $request = new GeocoderAddressRequest($address->getAddress());

            $response = $geocoder->geocode($request);

            if ($response->getStatus() === 'ZERO_RESULTS') {
                $invalidAddress = $address->getAddress();
                $this->addFlash(
                    'error',
                    "$invalidAddress is not a valid address!"
                );
                return $this->redirectToRoute('profile_index');
            }

            $results = $response->getResults();
            $em = $this->getDoctrine()->getManager();

            foreach ($results as $result) {
                $addressName = $result->getFormattedAddress();
                $lat = $result->getGeometry()->getLocation()->getLatitude();
                $lon = $result->getGeometry()->getLocation()->getLongitude();
                $address->setAddress($addressName);
                $address->setLatitude($lat);
                $address->setLongitude($lon);
            }

            $em->persist($address);
            $em->flush();

            $this->addFlash(
                'notice',
                'New shop added!'
            );

            return $this->redirectToRoute('profile_index', array('id' => $address->getId()));
        }


        $mapGenerator = $this->get('custom_map_generator');

        $map = $mapGenerator->generateMap($addresses);

//        $autocomplete = new Autocomplete();
//
//        $autocomplete->setInputId('appbundle_address_address');

//        $placeAutocompleteHelperBuilder = PlaceAutocompleteHelperBuilder::create();
//        $placeAutocompleteHelper = $placeAutocompleteHelperBuilder->build();
//        $placeAutocompleteHelperBuilder->getFormatter()->setDebug(true);
//        $placeAutocompleteHelperBuilder->getFormatter()->setIndentationStep(4);
////        $placeAutocompleteHelper->renderHtml($autocomplete);
////        $placeAutocompleteHelper->renderJavascript($autocomplete);
//        $auto =  $placeAutocompleteHelper->render($autocomplete);
////        echo $auto;
//        $apiHelperBuilder = ApiHelperBuilder::create();
//        $apiHelper = $apiHelperBuilder->build();
//        echo $apiHelper->render([$map, $auto]);

        return $this->render('Profile/profile.html.twig', array(
            'shops' => $addresses,
            'form' => $form->createView(),
            'map'  => $map,
//            'autocomplete'  => $autocomplete,
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
