<?php

namespace App\DataFixtures;

use App\Entity\Tutorials;

use App\DataFixtures\ChaptersFixtures;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class TutorialsFixtures extends Fixture implements DependentFixtureInterface
{
    public const LIST_TUTO=Array("C1"=>Array("1.1. Présentation"),
            "C2"=>Array("2.1. Lignes et colonnes", "2.2. Gérer les listes de données"), 
            "C3"=>Array("3.1. Trier une colonne en ordre décroissant", "3.2. Appliquer une fonction", "3.3. Mise en forme conditionnelle"), 
            "C4"=>Array("1.1. Présentation"),
            "C5"=>Array("2.1. Lignes et colonnes", "2.2. Gérer les listes de données"), 
            "C6"=>Array("3.1. Trier une colonne en ordre décroissant", "3.2. Appliquer une fonction", "3.3. Mise en forme conditionnelle"));
            
    public function load(ObjectManager $manager){
    
        foreach(self::LIST_TUTO as $chapter => $tuto){
            foreach ($tuto as $title){
                $tutorial = new Tutorials();
                $tutorial->setTitle($title);
                $tutorial->setUrl("/");
                $tutorial->setChapter($this->getReference($chapter));
                $manager->persist($tutorial);
            }
        } 
        
        $manager->flush();
    }
    public function getDependencies(){
        return array(
            ChaptersFixtures::class,
        );
    }
}
