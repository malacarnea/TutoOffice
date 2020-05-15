<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChaptersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add("title", TextType::class, [
                'attr'=>['name'=>'title', 'placeholder'=>'Titre du chapitre'],
                'label'=>false,
                ])
            ->add('formation', HiddenType::class, [
                'attr' => ['name'=>'formation', 'value'=>$options["id"]],
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
             'id' => 1,
        ]);
         $resolver->setAllowedTypes('id', 'int');
    }
}
