<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TutorialsType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add("title", TextType::class, [
                'attr' => ['name' => 'title', 'placeholder' => 'Titre du Tutoriel'],
                'label' => false,
            ])
            ->add("url", TextType::class, [
                'attr' => ['name' => 'url', 'placeholder' => 'Lien'],
                'label' => false,
            ])
            ->add('chapter', HiddenType::class, [
                'attr' => ['name' => 'chapter','value' => $options["id"]]
                ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'id' => 1,
        ]);
         $resolver->setAllowedTypes('id', 'int');
    }

}
