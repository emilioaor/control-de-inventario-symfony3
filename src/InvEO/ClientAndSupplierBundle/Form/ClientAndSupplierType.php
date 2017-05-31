<?php

namespace InvEO\ClientAndSupplierBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class ClientAndSupplierType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('rif', TextType::class, array(
                'label' => 'Rif',
                'attr' => array(
                    'placeholder' => 'Rif',
                    'class' => 'form-control'
                )
            ))

            ->add('name', TextType::class, array(
                'label' => 'Nombre',
                'attr' => array(
                    'placeholder' => 'Nombre',
                    'class' => 'form-control'
                )
            ))

            ->add('address', TextareaType::class, array(
                'label' => 'Direccion',
                'attr' => array(
                    'placeholder' => 'Direccion',
                    'class' => 'form-control'
                ),
                'required' => false
            ))

            ->add('phone', TextType::class, array(
                'label' => 'Telefono',
                'attr' => array(
                    'placeholder' => 'Telefono',
                    'class' => 'form-control'
                )
            ))

            ->add('mobile', TextType::class, array(
                'label' => 'Celular',
                'attr' => array(
                    'placeholder' => 'Celular',
                    'class' => 'form-control'
                )
            ))
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'InvEO\ClientAndSupplierBundle\Entity\ClientAndSupplier'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'clientAndSupplier';
    }


}
