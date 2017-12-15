<?php

namespace AppBundle\Controller;

use Ivory\GoogleMap\Base\Coordinate;
use Ivory\GoogleMap\Overlay\Icon;
use Ivory\GoogleMap\Overlay\Marker;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

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
//            var_dump($data);die;

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
        //*************** take lat and long *************************
        $lat = $request->request->get('lattitude');
        $long = $request->request->get('logitutde');

        $em = $this->getDoctrine()->getManager();

        $addresses = $em->getRepository('AppBundle:Address')->findAll();
        $products = $em->getRepository('AppBundle:Product')->findAll();
        $repository = $em->getRepository('AppBundle:User');
        $users = $repository->findAll();

        $mapGenerator = $this->get('custom_map_generator');

        $map = $mapGenerator->generateMap($addresses, $products);
        $map->setCenter(new Coordinate($long, $lat));
        $marker = new Marker(new Coordinate($long, $lat));
        $marker->setIcon(new Icon('https://i.imgur.com/pXpB7BR.png'));
        $map->getOverlayManager()->addMarker($marker);
        $map->setMapOption('zoom', 14);

        return $this->render(
            'Map/index.html.twig',
            [
                'addresses' => $addresses,
                'map' => $map,
                'users' => $users,
            ]
        );
    }

    public function registerAction()
    {
        return $this->redirectToRoute('homepage');
    }
}
