<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Customer;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class RegistrationCustomerController extends Controller
{

    public function registerAction()
    {
        return $this->container
            ->get('pugx_multi_user.registration_manager')
            ->register(Customer::class);
//        return $this->render('AppBundle:RegistrationCustomer:register.html.twig', array(
            // ...
//        ));
    }

}
