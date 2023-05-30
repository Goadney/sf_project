<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class UserModifType extends AbstractType
{
    public function __construct(private readonly Security $security)
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {


            // on recuperer l'utilisateur qui va être modifié par le formulaire
            $user = $event->getData();
            //on recupere l'object du formulaire
            $form = $event->getForm();
            // on recupere l'utilisateur connecté actuellement
            $userAuth = $this->security->getUser();

            if ($user == $userAuth) {
                $form->add('lastName', TextType::class, [
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
                    ]);
            }
            if ($this->security->isGranted('ROLE_ADMIN')) {
                $form->add('roles', ChoiceType::class, [
                    'choices' => [
                        'Utilisateur' => 'ROLE_USER',
                        'Editeur' => 'ROLE_EDITOR',
                        'Administrateur' => 'ROLE_ADMIN',
                    ],
                    'required' => false,
                    'expanded' => true,
                    'multiple' => true,
                    'label' => 'Rôles :',
                    'attr' => [
                        'placeholder' => 'Sélectionner les rôles',
                    ]
                ]);
            };
        });
    }
    // $builder
    //     ->add('email')
    //     ->add('roles')
    //     ->add('password')
    //     ->add('firstName')
    //     ->add('lastName')
    // ;


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
