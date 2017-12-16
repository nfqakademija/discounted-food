<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class FoodFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'meal',
                CheckboxType::class,
                array('required' => false, 'label' => 'Meal','attr' => array("autocomplete" => "off"))
            )
            ->add('dessert', CheckboxType::class, array('required' => false, 'label' => 'Dessert'))
            ->add('vegan', CheckboxType::class, array('required' => false, 'label' => 'Vegan'))
            ->add('vegetarian', CheckboxType::class, array('required' => false, 'label' => 'Vegetarian'))
            ->add(
                'filter',
                SubmitType::class,
                array(
                    'attr' => array('class' => 'btn btn-success'),
                )
            );
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_food_filter';
    }
}
