<?php

namespace App\Form;

use App\Entity\Categories;
use App\Entity\Formations;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FormationsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add("title", TextType::class, [
                'attr'=>['name'=>'title', 'placeholder'=>'Titre de la formation'],
                'label'=>false,
                ])
            ->add('category', EntityType::class, [
                'class'=>Categories::class,
                'choice_label'=>'name',
                'multiple'=>false,
                'expanded'=>false,
                'attr'=>['name'=>'category'],
                'label'=>false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Formations::class,
        ]);
    }
}
