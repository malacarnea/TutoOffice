<?php

namespace App\Services;

use App\Entity\Chapters;
use App\Entity\Formations;
use App\Entity\Tutorials;
use Doctrine\ORM\EntityManagerInterface;
/**
 * Description of FormationsListService
 *
 * @author alicia
 */
class FormationsListService {
    
    private $em;
    
    public function __construct(EntityManagerInterface $em) {
        $this->em=$em;
    }
    
    /**
     * Find chapters and tutorials attached to formations list
     * @param Array $formations
     * @return array
     */
    public function getFormationsCT($formations):Array{
        $toSend=Array();
          //get chapters
        foreach ($formations as $formation) {
            $chapters = $this->em->getRepository(Chapters::class)->findBy(["formation" => $formation->getId()]);   
            usort($chapters, [$this, "chaptersSort"]);
            $temp_chap = Array();
            foreach ($chapters as $chapter) {
                $tutorials = $this->em->getRepository(Tutorials::class)->findBy(["chapter" => $chapter->getId()]);
                usort($tutorials, [$this,"tutorialsSort"]);
                array_push($temp_chap, Array("chapter" => $chapter, "tutorials" => $tutorials));
            }
            array_push($toSend, Array("formation" => $formation, "chapters" => $temp_chap));
        }
        return $toSend;
    }
    
    static function chaptersSort($a, $b):int{
        $aSplit=explode(".", $a->getTitle());
        $bSplit=explode(".", $b->getTitle());
        $ca=intval($aSplit[0]);
        $cb=intval($bSplit[0]);
        return $ca<=>$cb;
    }
    static function tutorialsSort($a, $b):int{
        $ca=intval(explode(".", $a->getTitle())[1]);
        $cb=intval(explode(".", $b->getTitle())[1]);
        return $ca<=>$cb;
    }
}
