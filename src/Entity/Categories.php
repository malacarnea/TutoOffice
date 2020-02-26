<?php

namespace App\Entity;

use App\Entity\Formations;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoriesRepository")
 */
class Categories {

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Formations", cascade={"persist", "remove"}, mappedBy="category") 
     */
    protected $formations;

    public function __construct() {
        $this->formations = new ArrayCollection();
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function getName(): ?string {
        return $this->name;
    }

    public function setName(string $name): self {
        $this->name = $name;

        return $this;
    }

    public function getFormations(): ?Formations {
        return $this->formations;
    }

    public function addFormation(Formations $form) {
        $this->formations->add($form);
        $form->setCategory($this);
    }

}
