<?php

namespace App\Entity;


use App\Entity\Chapters;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TutorialsRepository")
 * @Vich\Uploadable
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
     * @Assert\Regex(pattern="/(^[0-9]+\.[0-9]+\.)/", message="Le titre doit débuter selon ce modèle : '1.1.' Attention à bien re-sélectionner la vidéo après correction du titre.")
     * @Assert\Length(min=10, max=255, minMessage="Le titre est trop court. Il doit avoir au moins 10 caractères.", maxMessage="Le titre est trop long. Il doit faire moins de 255 caractères.")
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $url;
    
    /**
     * @Vich\UploadableField(mapping="tuto_files", fileNameProperty="url", size="tutoSize")
     * @Assert\File(maxSize ="300M", mimeTypes = {"video/mp4"}, mimeTypesMessage ="Votre fichier doit être de type MP4", maxSizeMessage ="Votre fichier ne doit pas dépasser {{ limit }}{{suffix}}.")
     * @var File|null
     */
    private $tuto;
    
    /**
     * @ORM\Column(type="integer")
     *
     * @var int|null
     */
    private $tutoSize;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var \DateTimeInterface|null
     */
    private $updatedAt;
    
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

    public function setUrl(?string $url): ?self
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
            
    
    public function getTutoSize():int{
        return $this->tutoSize;
    }
    public function setTutoSize(?int $size): ?self{
        $this->tutoSize=$size;
        return $this;
    }
    
    public function getTuto():?File{
        return $this->tuto;
    }
    
    public function setTuto(?File $tuto):void{
        $this->tuto=$tuto;
         if (null !== $tuto) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }
 
}
