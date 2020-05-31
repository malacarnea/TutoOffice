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
                    'attr' => ['name' => 'lastname',],  
                    'label'=>"Nom",
                ])
                ->add('firstname', TextType::class, [
                    'attr' => ['name' => 'firstname',],       
                    'label'=> 'Prénom',
                ])
                ->add('email', EmailType::class, [
                    'attr' => ['name' => 'email',],      
                    'label'=>'Email',
                ])
                ->add('roles', ChoiceType::class, [
                    'choices' => [
                        'Admin'=> 'ROLE_ADMIN',
                        'Formateur'=> 'ROLE_TEACHER',
                        'Stagiaire'=>'ROLE_TRAINEE'
                    ],
                    'multiple' => true,
                    'expanded' => false,
                    'attr' => ['name' => 'roles'],
                    'label' =>'Roles de l\'utilisateur',
                ])
                ->add('access', DateIntervalType::class, [
                    'widget' => 'choice', // render a text field for each part
                    // 'input'    => 'string',  // if you want the field to return a ISO 8601 string back to you
                    // customize which text boxes are shown
                    'years' => range(1,10),
                    'months' => range(1,12),
                    'with_days'=>false,
                    'label'=>"Accès",
                    'labels'=>[
                        'months'=>'Mois',
                        'years'=>'Années',
                    ],
                ])
                ->add('formations', EntityType::class, [
                    'class' => Formations::class,
                    'choice_label' => 'title',
                    'multiple' => true,
                    'expanded' => false,
                    'attr' => ['name' => 'formations'],
                    'label'=>'Peut suivre les formations :',
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => Users::class,
        ]);
    }

}
