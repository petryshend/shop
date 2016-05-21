<?php

namespace BackEndBundle\Form;

use BackEndBundle\Entity\Product;
use Doctrine\DBAL\Types\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('description')
            ->add('price')
            ->add('image_url', UrlType::class, [
                'required' => false,
            ])
            ->add('category', EntityType::class, [
                'class' => 'BackEndBundle\Entity\Category',
                'choice_label' => 'name'
            ])
        ;
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => Product::class,
            ]
        );
    }

    public function getName(): string
    {
        return 'product_type';
    }
}
