<?php

namespace App\DataFixtures;

use App\Entity\Formations;
use App\DataFixtures\CategoriesFixtures;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class FormationsFixtures extends Fixture implements DependentFixtureInterface
{
    public const LIST_FORMATIONS=Array("F1"=>"Excel Initiation", "F2"=>"Tableaux Croisés Dynamiques");
    public function load(ObjectManager $manager){
    
        foreach(self::LIST_FORMATIONS as $ref => $title){
            $f = new Formations();
            $f->setTitle($title);
            $f->setCategory($this->getReference(CategoriesFixtures::LIST_CATEGORIES[0]));
            $this->addReference($ref, $f);
            $manager->persist($f);
        } 
        
        $manager->flush();
    }
    public function getDependencies(){
        return array(
            CategoriesFixtures::class,
        );
    }
}
