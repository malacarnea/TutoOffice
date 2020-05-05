<?php

namespace App\DataFixtures;

use App\Entity\Chapters;
use App\DataFixtures\FormationsFixtures;
use App\DataFixtures\CategoriesFixtures;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class ChaptersFixtures extends Fixture implements DependentFixtureInterface
{
    public const LIST_CHAPTERS=Array("F1"=>Array("C1"=>"1. Présentation",
            "C2"=>"2. Base de Données", "C3"=>"3. Les filtres"), 
                                    "F2"=>Array("C4"=>"1. Présentation",
            "C5"=>"2. Les Tableaux Croisés Dynamiques", "C6"=>"3. Générer des graphiques"));
    public function load(ObjectManager $manager){
    
        foreach(self::LIST_CHAPTERS as $formation => $chap){
            foreach ($chap as $ref => $title){
                $chapter = new Chapters();
                $chapter->setTitle($title);
                $chapter->setFormation($this->getReference($formation));
                $this->addReference($ref, $chapter);
                $manager->persist($chapter);
            }
        } 
        
        $manager->flush();
    }
    public function getDependencies(){
        return array(
            FormationsFixtures::class,
        );
    }
}
