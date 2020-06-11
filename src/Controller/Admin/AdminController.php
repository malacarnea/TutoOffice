<?php

namespace App\Controller\Admin;

use App\Entity\Chapters;
use App\Entity\Formations;
use App\Entity\Tutorials;
use App\Entity\Users;
use App\Services\FormationsListService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("admin")
 * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_TEACHER')")
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
    public function indexFormations(FormationsListService $formList) {
        $toSend = Array();
        //send all formations for admin/teacher user
        $formations = $this->em->getRepository(Formations::class)->findAll();
        $toSend=$formList->getFormationsCT($formations);
        return $this->render('site/admin/formations.html.twig', [
                    'formations' => $toSend,
        ]);
    }
    /**
     * @Route("/users", name="admin.index.users")
     * @return type
     */
    public function indexUsers(){
        $users=$this->em->getRepository(Users::class)->findAll();
        return $this->render('site/admin/users.html.twig', [
                    'users' => $users,
        ]);
        
    }
    

}
