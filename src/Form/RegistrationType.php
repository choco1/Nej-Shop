<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', TextType::class,[
                'attr' => [
                    'placeholder' => "Votre email"
                ]])

            ->add('username', TextType::class,[
                'attr' => [
                'placeholder' => "Votre nom d'utilisateur"
            ]])

            ->add('password', PasswordType::class,[
                'attr' => [
                    'placeholder' => "Votre mot de passe"
                ]]);
/*
            ->add('confirm_password', PasswordType::class,[
                'attr' => [
                    'placeholder' => "Veilliez confirmer votre mot de passe"
                ]])
        ;
*/
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
