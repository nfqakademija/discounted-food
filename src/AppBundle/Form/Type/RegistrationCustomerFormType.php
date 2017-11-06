<?php
/**
 * Created by PhpStorm.
 * User: triangle
 * Date: 17.10.29
 * Time: 12.38
 */

namespace AppBundle\Form\Type;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class RegistrationCustomerFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->remove('username');
    }

//    public function getParent()
//    {
//        return 'FOS\UserBundle\Form\Type\RegistrationFormType';
//    }
//
//    public function getBlockPrefix()
//    {
//        return 'customer_registration';
//    }

}