<?php

namespace App\DataFixtures;
use App\Entity\Categories;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoriesFixtures extends Fixture
{
    public const LIST_CATEGORIES=Array("Excel", "Word", "PowerPoint");
    public function load(ObjectManager $manager)
    {
        foreach(self::LIST_CATEGORIES as $name){
            $cat = new Categories();
            $cat->setName($name);
            $this->addReference($name, $cat);
            $manager->persist($cat);
        } 
        
        $manager->flush();
    }
}
