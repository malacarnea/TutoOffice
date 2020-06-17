<?php

namespace App\Form;

use App\Entity\Tutorials;
use App\Form\DataTransformer\ChaptersTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TutorialsType extends AbstractType {

    private $transformer;

    public function __construct(ChaptersTransformer $transformer) {
        $this->transformer = $transformer;
    }

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add("title", TextType::class, [
                    'attr' => ['name' => 'title'],
                    'label' => "Titre",
                ])
                ->add("tuto", VichFileType::class, [
                    'required' => false,
                    'allow_delete' => true,
                    'download_uri' => true,
                    'asset_helper' => true,
                    'label'=>"Fichier",
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
