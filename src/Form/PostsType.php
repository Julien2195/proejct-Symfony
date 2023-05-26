<?php

namespace App\Form;

use App\Entity\Posts;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use FOS\CKEditorBundle\Form\Type\CKEditorType;

class PostsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('auteur', null, [
                'attr' => [
                    'class' => 'article-auteur'
                ]
            ])
            ->add('titre', null, [
                'attr' => [
                    'class' => 'article-titre'
                ]
            ])
            ->add('description', TextareaType::class, [
                'attr' => [
                    'class' => 'article-description'
                ]
            ])
            ->add('content', CKEditorType::class, [
                'attr' => [
                    'class' => 'article-content'

                ]
            ])

            ->add('date')
            ->add('visible', CheckboxType::class, [
                'attr' => [
                    'class' => 'form-check-input',
                ],
            ])
            ->add('image', FileType::class, [
                'label' => "Image",
                'required' => true,
                'data_class' => null,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Posts::class,
        ]);
    }
}
