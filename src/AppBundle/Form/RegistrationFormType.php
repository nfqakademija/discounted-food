<?php
/**
 * Created by PhpStorm.
 * User: triangle
 * Date: 17.10.12
 * Time: 10.26
 */

namespace AppBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseRegistrationFormType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('companyName')->add('legalEntityCode')->add('phone');
    }

    public function getParent()
    {
        return BaseRegistrationFormType::class;
    }


}