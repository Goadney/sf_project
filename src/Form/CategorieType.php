<?php

namespace App\Form;

use App\Entity\Categorie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class CategorieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('titre', TextType::class, [
            'label' => 'Titre :',
            'required' => true,
            'attr' => [
                'placeholder' => 'Informatique..'
            ]
        ])
        
        ->add('actif', CheckboxType::class, [
            'label' => 'Actif ',
            'required' => false

        ])
        // Il faut absolument que ce soit equivalement a un champ de la classe Article titre = titre
    ;
}

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Categorie::class,
        ]);
    }
}
