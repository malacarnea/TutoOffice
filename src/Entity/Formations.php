<?php

namespace App\Entity;

use App\Entity\Chapters;
use App\Entity\Categories;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FormationsRepository")
 */
class Formations
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank
     * @Assert\Type("string")
     * @ORM\Column(type="string", length=255)
     */
    private $title;
    
     /**
     * @ORM\OneToMany(targetEntity="App\Entity\Chapters", cascade={"persist", "remove"}, mappedBy="formation") 
     */
    protected $chapters;
    
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Categories", inversedBy="formations")
     */
    protected $category;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", mappedBy="formations")
     */
    private $users;
    
    public function __construct(){
        $this->chapters=new ArrayCollection();
        $this->users = new ArrayCollection();
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

    public function getLevel(): ?int
    {
        return $this->level;
    }

    public function setLevel(?int $level): self
    {
        $this->level = $level;

        return $this;
    }
    
    public function getChapters() : ?Chapters{
        return $this->chapters;
    }
    public function addChapter(Chapters $chap){
        $this->chapters->add($chap);
        $chap->setFormation($this);
    }
    
    public function getCategory():?Categories{
        return $this->category;
    }
    
    public function setCategory(Categories $cat){
        $this->category=$cat;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->addFormation($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
            $user->removeFormation($this);
        }

        return $this;
    }
}
