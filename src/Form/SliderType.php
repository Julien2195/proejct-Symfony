<?php

namespace App\Form;

use App\Entity\Slider;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SliderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('titre', null, [
                'attr' => [
                    'class' => 'article-titre'
                ],
                'label' => "Titre",
                'required' => true,
            ])
            ->add('description', null, [
                'attr' => [
                    'class' => 'article-description'
                ],
                'label' => "Description",
                'required' => true,
            ])->add('image', FileType::class, [
                'label' => "Image",
                'required' => true,
                'data_class' => null,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([]);
    }
}
