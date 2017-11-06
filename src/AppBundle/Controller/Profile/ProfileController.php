<?php

namespace AppBundle\Controller\Profile;

use Faker\Factory;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/profile", name="profile")
 */
class ProfileController extends Controller
{
  /**
   * @Route("/", name="profile_index")
   */
  public function indexAction(Request $request)
  {
      // replace this example code with whatever you need
      return $this->render('Profile/profile.html.twig');
  }


}
