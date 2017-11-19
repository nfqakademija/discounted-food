<?php

namespace AppBundle\Controller;

use AppBundle\Service\MapGenerator;
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


      return $this->render('default/index.html.twig',[
          'addresses' => $addresses,
          'map' => $map,
          'products' =>$products,
          'users' => $users,
      ]);
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
     * @Route("/faker", name="faker")
     */
    public function fakerAction(Request $request)
    {
        $faker = Factory::create();

        for ($i = 0 ; $i <10 ; $i++ )
            echo $faker->name.'<br>';

        die;
    }

    public function registerAction()
    {
        return $this->redirectToRoute('homepage');
    }

}
