<?php

namespace AppBundle\Controller;

use Faker\Factory;
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
                'foodFilterForm' => $foodFilterForm->createView()
            ]
        );
    }

    /**
     * @Route("/about", name="about")
     */
    public function aboutAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('About/about.html.twig');
    }

    /**
     * @Route("/map", name="map")
     */
    public function mapAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $addresses = $em->getRepository('AppBundle:Address')->findAll();
        $products = $em->getRepository('AppBundle:Product')->findAll();
        $repository = $em->getRepository('AppBundle:User');
        $users = $repository->findAll();

        $mapGenerator = $this->get('custom_map_generator');

        $map = $mapGenerator->generateMap($addresses, $products);


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
