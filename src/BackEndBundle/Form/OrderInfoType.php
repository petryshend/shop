<?php

namespace BackEndBundle\Form;

use BackEndBundle\Entity\OrderInfo;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderInfoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('first_name')
            ->add('last_name')
            ->add('country')
            ->add('postcode')
            ->add('address_line')
            ->add('email_address')
            ->add('phone_number')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => OrderInfo::class
            ]
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'order_info_type';
    }
}