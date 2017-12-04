<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Subscribe;
use AppBundle\Form\SubscribeType;
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
            ]
        );
    }

    /**
     * @Route("/subscribe", name="subscribe")
     */
    public function subscribeAction(Request $request)
    {
        $form = $this->createForm(SubscribeType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $subsriber = new Subscribe();
            $email = $form["email"]->getData();
            $subsriber->setEmail($email);

            $em->persist($subsriber);
            $em->flush();

            $this->addFlash(
                'notice',
                'You were added to our subsribers list!'
            );
            return $this->redirect($request->getUri());
        }

        return $this->render('Subscribe/subscribe.html.twig', array('form' => $form->createView()));
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
