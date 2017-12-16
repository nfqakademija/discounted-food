<?php

namespace AppBundle\Controller;

use Ivory\GoogleMap\Base\Coordinate;
use Ivory\GoogleMap\Overlay\Icon;
use Ivory\GoogleMap\Overlay\Marker;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $addresses = $em->getRepository('AppBundle:Address')->findAll();

        $repository = $em->getRepository('AppBundle:Product');
        $products = $repository->findAll();


        $foodFilterForm = $this->createForm('AppBundle\Form\FoodFilterType');

        $foodFilterForm->handleRequest($request);

        if ($foodFilterForm->isSubmitted() && $foodFilterForm->isValid()) {
            $data = $foodFilterForm->getData();

            foreach ($data as $index => $value) {
                if ($data[$index] === false) {
                    unset($data[$index]);
                }
            }

            $products = $repository->findBy(
                $data
            );
        }


        $repository = $em->getRepository('AppBundle:User');
        $users = $repository->findAll();

        $mapGenerator = $this->get('custom_map_generator');

        $map = $mapGenerator->generateMap($addresses);


        return $this->render(
            'default/index.html.twig',
            [
                'addresses' => $addresses,
                'map' => $map,
                'products' => $products,
                'users' => $users,
                'foodFilterForm' => $foodFilterForm->createView(),
            ]
        );
    }

    /**
     * @Route("/aboutus", name="about")
     */
    public function aboutAction(Request $request)
    {
        return $this->render('About/about.html.twig');
    }

    /**
     * @Route("/map", name="map")
     */
    public function mapAction(Request $request)
    {
        $session = new Session();
        $lat = $session->get('lattitude');
        $long = $session->get('longitude');

        $latPost = $request->request->get('lattitude');
        $longPost = $request->request->get('longitude');
        $foodName = $request->request->get('foodName');

        $em = $this->getDoctrine()->getManager();
        if ($foodName == null) {
            $products = $em->getRepository('AppBundle:Product')->findAll();
        } else {
            $products = $em->getRepository('AppBundle:Product')->getFindAllFoodQueryBuilder($foodName);
        }
        $addresses = $em->getRepository('AppBundle:Address')->findAll();

        $repository = $em->getRepository('AppBundle:User');
        $users = $repository->findAll();

        if ($foodName == null) {
            $mapGenerator = $this->get('custom_map_generator');
        } else {
            $mapGenerator = $this->get('custom_search_map_generator');
        }

        $map = $mapGenerator->generateMap($addresses, $products);

        if ($latPost != null && $longPost != null) {
            $map->setCenter(new Coordinate($latPost, $longPost));
            $map->setMapOption('zoom', 13);
        } else {
            if ($lat != null && $long != null) {
                $map->setCenter(new Coordinate($lat, $long));
                $marker = new Marker(new Coordinate($lat, $long));
                $marker->setIcon(new Icon('https://i.imgur.com/pXpB7BR.png'));
                $map->getOverlayManager()->addMarker($marker);
                $map->setMapOption('zoom', 14);
            } else {
                $map->setCenter(new Coordinate(54.687157, 25.279652));
                $map->setMapOption('zoom', 13);
            }
        }

        return $this->render(
            'Map/index.html.twig',
            [
                'addresses' => $addresses,
                'map' => $map,
                'users' => $users,
            ]
        );
    }

    /**
     * @Route("/get/location", name="set_location")
     */
    public function locationAction(Request $request)
    {
        $lat = $request->request->get('lattitude');
        $long = $request->request->get('longitude');

        $session = new Session();
        $session->set('lattitude', $lat);
        $session->set('longitude', $long);
        die;
    }


    public function registerAction()
    {
        return $this->redirectToRoute('homepage');
    }
}
