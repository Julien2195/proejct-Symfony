<?php

namespace App\Form;

use App\Entity\Posts;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

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
            ->add('description', null, [
                'attr' => [
                    'class' => 'article-description'
                ]
            ])
            ->add('content', TextareaType::class, [
                'attr' => [
                    'class' => 'article-content'
                ]
            ])
            // ->add('slug')
            ->add('date')
            ->add('visible', CheckboxType::class, [
                'attr' => [
                    'class' => 'article-visible'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Posts::class,
        ]);
    }
}
