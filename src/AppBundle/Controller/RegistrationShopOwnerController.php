<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class RegistrationShopOwnerController extends Controller
{

    public function RegisterAction()
    {
        return $this->container
            ->get('pugx_multi_user.registration_manager')
            ->register('AppBundle\Entity\ShopOwner');

//        return $this->render('AppBundle:RegistrationShopOwner:register.html.twig', array(
            // ...
//        ));
    }

}
