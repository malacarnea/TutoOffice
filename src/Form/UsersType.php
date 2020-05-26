<?php

namespace App\Form;

use App\Entity\Formations;
use App\Entity\Users;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateIntervalType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UsersType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('lastname', TextType::class, [
                    'attr' => ['name' => 'lastname', 'placeholder' => 'Nom',],  
                    'label'=>false,
                ])
                ->add('firstname', TextType::class, [
                    'attr' => ['name' => 'firstname', 'placeholder' => 'Prénom',],       
                    'label'=>false,
                ])
                ->add('email', EmailType::class, [
                    'attr' => ['name' => 'email', 'placeholder' => 'Email',],      
                    'label'=>false,
                ])
                ->add('roles', ChoiceType::class, [
                    'choices' => [
                        'Admin'=> 'admin',
                        'Formateur'=> 'teacher',
                        'Stagiaire' => 'user',
                    ],
                    'multiple' => true,
                    'expanded' => true,
                    'attr' => ['name' => 'roles'],
                ])
                ->add('access', DateIntervalType::class, [
                    'widget' => 'integer', // render a text field for each part
                    // 'input'    => 'string',  // if you want the field to return a ISO 8601 string back to you
                    // customize which text boxes are shown
                    'with_years' => true,
                    'with_months' => true,
                    'with_days' => true,
                    'with_hours' => false,
                    'label'=>false,
                ])
                ->add('formations', EntityType::class, [
                    'class' => Formations::class,
                    'choice_label' => 'title',
                    'multiple' => false,
                    'expanded' => false,
                    'attr' => ['name' => 'formations'],
                    'label'=>false,
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => Users::class,
        ]);
    }

}
