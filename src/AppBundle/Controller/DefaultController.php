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
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig');
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

}
