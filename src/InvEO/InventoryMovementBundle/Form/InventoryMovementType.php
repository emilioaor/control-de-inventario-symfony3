<?php

namespace InvEO\InventoryMovementBundle\Form;

use InvEO\ClientAndSupplierBundle\Entity\ClientAndSupplier;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Doctrine\Common\Persistence\ObjectManager;

use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class InventoryMovementType extends AbstractType
{

    private $choices = array();

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('dateIssue', DateType::class, array(
                'label' => 'Fecha de entrada',
                'attr' => array(
                    'class' => 'form-control',
                    'placeholder' => 'Fecha de entrada'
                ),
                'format' => 'dMy'
            ))

        ;

        if (isset($options['clientAndSupplierChoices']) && $options['clientAndSupplierChoices']) {

            $builder->add('fkClientAndSupplier', ChoiceType::class, array(
                'label' => 'Proveedor',
                'attr' => array(
                    'class' => 'form-control'
                ),
                'choices' => $options['clientAndSupplierChoices']
            ));
        }


    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'InvEO\InventoryMovementBundle\Entity\InventoryMovement',
            'clientAndSupplierChoices' => null,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'inventoryMovement';
    }

    /**
     * @return array
     */
    public function getChoices()
    {
        return $this->choices;
    }

    /**
     * @param array $choices
     */
    public function setChoices($choices)
    {
        $this->choices = $choices;
    }

}
