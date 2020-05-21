<?php

namespace App\Form;

use App\Entity\Tutorials;
use App\Form\DataTransformer\ChaptersTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TutorialsType extends AbstractType {

    private $transformer;
    public function __construct(ChaptersTransformer $transformer){
        $this->transformer=$transformer;
    }
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
                 'invalid_message' => 'Le transformer a buggé',
                ])

        ;
        $builder->get('chapter')
                ->addModelTransformer($this->transformer);
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => Tutorials::class,
        ]);
    }

}
