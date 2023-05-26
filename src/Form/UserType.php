<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class UserType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('lastName', TextType::class, [
                'label' => 'Nom :',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Entrez votre Nom',
                ]
            ])
            ->add('firstName', TextType::class, [
                'label' => 'Prénom :',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Entrez votre prénom',
                ]
            ])
            ->add('email',  EmailType::class, [
                'label' => 'Email :',
                'required' => true,
                'attr' => [
                    'placeholder' => 'JohnDoe@coucou.com',
                ]
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'The password fields must match.',
                'options' => ['attr' => ['class' => 'password-field']],
                'required' => true,
                'first_options'  => [
                    'label' => 'Mot de Passe :',
                    'attr' => [
                        'placeholder' => 'S3CRET',
                    ]
                ],
                'second_options' => [
                    'label' => 'Repéter le Mot de Passe :',
                    'attr' => [
                        'placeholder' => 'S3CRET',
                    ]
                ],
                'mapped' => false // pour ne pas préremplir dans le $user quand on create form
            ]);;
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
