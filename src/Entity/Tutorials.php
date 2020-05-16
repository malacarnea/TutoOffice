<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Chapters;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TutorialsRepository")
 */
class Tutorials
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
     * @Assert\NotBlank
     * @Assert\Url(message="L'url n'est pas valide")
     * @ORM\Column(type="string", length=255)
     */
    private $url;
    
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Chapters", inversedBy="tutorials")
     */
    protected $chapter; 

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

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }
    
    public function getChapter(): ?Chapters{
        return $this->chapter;
    }
    public function setChapter(Chapters $chap){
        $this->chapter=$chap;
    }
            
}
