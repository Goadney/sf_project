<?php

namespace App\Form;

use App\Entity\Article;
use Doctrine\DBAL\Types\BooleanType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ArticlesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TextType::class, [
                'label' => 'Titre :',
                'required' => true,
                'attr' => [
                    'placeholder' => 'La dernière maj d\'Apple !'
                ]
            ])
            ->add('imageFile', VichImageType::class, [
                'label' => 'Image :',
                'required' => false,
                'delete_label' => "Supprimer l\'image",
                'allow_delete' => true,
                'download_uri' => false, //interdire le dl de l'image via le form
                'image_uri' => true,
                'attr' => [
                    'class' => 'form-control-file'
                ]
            ])




            ->add('contenu', TextareaType::class, [
                'label' => 'Contenu :',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Une mise a jour dévastatrice mais ...',
                    'rows' => 5,
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
            'data_class' => Article::class,
        ]);
    }
}
