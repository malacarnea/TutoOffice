<?php

namespace App\Entity;

use App\Entity\Formations;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ChaptersRepository")
 */
class Chapters
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;
    
     /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Formations", inversedBy="chapters") 
     */
    protected $formation;
    
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Tutorials", cascade={"persist", "remove"}, mappedBy="chapter")
     */
    protected $tutorials;
    
    public function __construct(){
        $this->tutorials=new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }
    public function getFormation():?Formation{
        return $this->formation;
    }
    
    public function setFormation(Formations $form){
        $this->formation=$form;
    }
    
    public function getTutorials():?Tutorials {
        return $this->tutorials;
    }
    
    public function addTutorial(Tutorials $tuto){
        $this->tutorials->add($tuto);
        $tuto->setChapter($this);
    }
    
}
