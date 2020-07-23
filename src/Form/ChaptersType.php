<?php

namespace App\Form;

use App\Entity\Chapters;
use App\Form\DataTransformer\FormationsTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChaptersType extends AbstractType {

    private $transformer;

    public function __construct(FormationsTransformer $transformer) {
        $this->transformer = $transformer;
    }

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add("title", TextType::class, [
                    'attr' => ['name' => 'title',],
                    'label' => "Titre",
                ])
                ->add('formation', HiddenType::class, [
                    'invalid_message' => 'Le transformer a buggé',
                ])
        ;
        $builder->get('formation')
                ->addModelTransformer($this->transformer);
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => Chapters::class,
        ]);
    }

}
