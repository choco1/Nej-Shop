<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Color;
use App\Entity\Product;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',TextType::class, [
                'attr' => [
                    'placeholder' => "Nom du produit"
                ]
            ])
            ->add('description', TextareaType::class, [
                'attr' => [
                    'placeholder' => "Description du produit"
                    ]
                ])
            ->add('image', FileType::class, [
                'mapped' => false,
                'attr' => [
                    'placeholder' => "Image du produit"
                ]
            ])
            ->add('price', MoneyType::class, [
                'divisor' => 1,
                'attr' => [
                    'placeholder' => "Prix du produit"
                ]
                ])

            ->add('color', null, [
                'choice_label' => 'name_of_calor',
                'expanded' => true,

            ])

            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
                'expanded' => true,
            ])

            ->add('favorit', ChoiceType::class, [
                'label' => 'Vous aimez ?',
                'choices' => [
                    'No' => false,
                    'Yes' => true,
                ]
            ])
            ->add('date', DateType::class, [
                'widget' => 'choice',
                'attr' => [
                    'placeholder' => "Date du produit"
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
