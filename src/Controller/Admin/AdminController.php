<?php

namespace App\Controller\Admin;

use App\Entity\Chapters;
use App\Entity\Formations;
use App\Entity\Tutorials;
use App\Entity\Users;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("admin")
 */
class AdminController extends AbstractController {

    private $em;

    public function __construct(EntityManagerInterface $em) {
        $this->em = $em;
    }
    
    /**
     * @Route("/", name="admin.index.formations")
     * @return type
     */
    public function indexFormations() {
        //pour la mise en place des utilisateurs, il faudra checker si l'utilisateur peut 
        //bien suivre la formation et adapter la requete en fonction
        $toSend = Array();
        $formations = $this->em->getRepository(Formations::class)->findAll();
        //get chapters
        foreach ($formations as $formation) {
            $chapters = $this->em->getRepository(Chapters::class)->findBy(["formation" => $formation->getId()]);
            $temp_chap = Array();
            foreach ($chapters as $chapter) {
                $tutorials = $this->em->getRepository(Tutorials::class)->findBy(["chapter" => $chapter->getId()]);
                array_push($temp_chap, Array("chapter" => $chapter, "tutorials" => $tutorials));
            }
            array_push($toSend, Array("formation" => $formation, "chapters" => $temp_chap));
        }
        
        $users=$this->em->getRepository(Users::class)->findAll();
        return $this->render('site/admin/list_formations.html.twig', [
                    'formations' => $toSend,
        ]);
    }
    /**
     * @Route("/users", name="admin.index.users")
     * @return type
     */
    public function indexUsers(){
        $users=$this->em->getRepository(Users::class)->findAll();
        return $this->render('site/admin/list_users.html.twig', [
                    'users' => $users,
        ]);
        
    }
    

}
