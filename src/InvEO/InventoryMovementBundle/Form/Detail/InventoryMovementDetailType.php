<?php

namespace InvEO\InventoryMovementBundle\Form\Detail;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class InventoryMovementDetailType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('fkProduct', ChoiceType::class, array(
                'attr' => array(
                    'class' => 'form-control'
                ),
                'choices' => $options['products']
            ))

            ->add('quantity', NumberType::class, array(
                'attr' => array(
                    'class' => 'form-control'
                ),
            ))

            ->add('cost', NumberType::class, array(
                'attr' => array(
                    'class' => 'form-control'
                )
            ))

            ->add('total', NumberType::class, array(
                'attr' => array(
                    'class' => 'form-control',
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
            'data_class' => 'InvEO\InventoryMovementBundle\Entity\Detail\InventoryMovementDetail',
            'products' => array()
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'inventoryMovementDetail';
    }


}
