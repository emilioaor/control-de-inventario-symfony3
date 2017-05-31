<?php

namespace InvEO\ProductBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class ProductType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('name', TextType::class, array(
                'label' => 'Nombre',
                'attr' => array(
                    'placeholder' => 'Nombre',
                    'class' => 'form-control'
                )
            ))

            ->add('description', TextareaType::class, array(
                'label' => 'Descripcion',
                'attr' => array(
                    'placeholder' => 'Descripcion',
                    'class' => 'form-control'
                ),
                'required' => false
            ))

            ->add('price', NumberType::class, array(
                'label' => 'Precio',
                'attr' => array(
                    'placeholder' => 'Precio',
                    'class' => 'form-control'
                ),
                'invalid_message' => 'Precio no cumple el formato correcto'
            ))

            ->add('stockMinimum', NumberType::class, array(
                'label' => 'Stock minimo',
                'attr' => array(
                    'placeholder' => 'Stock minimo',
                    'class' => 'form-control'
                ),
                'invalid_message' => 'Stock minimo no cumple el formato correcto'
            ))

            ->add('stockMaximum', NumberType::class, array(
                'label' => 'Stock maximo',
                'attr' => array(
                    'placeholder' => 'Stock maximo',
                    'class' => 'form-control'
                ),
                'invalid_message' => 'Stock maximo no cumple el formato correcto'
            ))
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'InvEO\ProductBundle\Entity\Product',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'product';
    }


}
