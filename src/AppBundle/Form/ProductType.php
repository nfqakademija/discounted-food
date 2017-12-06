<?php

namespace AppBundle\Form;

use AppBundle\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ProductType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('addressId', HiddenType::class)
            ->add('name')
            ->add('description')
            ->add('portions')
            ->add('price')
            ->add(
                'dateFrom',
                DateTimeType::class,
                array(
                    'widget' => 'single_text',
                    'label' => 'Pick a date when food offer starts'
                )
            )
            ->add(
                'dateTo',
                DateTimeType::class,
                array(
                    'widget' => 'single_text',
                    'label' => 'Pick a date when food offer expires'
                )
            )
            ->add('imageFile', VichImageType::class, array('required' => false, 'label' => 'Food photo' ));

        $builder
            ->add('meal', CheckboxType::class, array('required' => false))
            ->add('vegetarian', CheckboxType::class, array('required' => false))
            ->add('vegan', CheckboxType::class, array('required' => false))
            ->add('dessert', CheckboxType::class, array('required' => false));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array('data_class' => Product::class));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_product';
    }
}
