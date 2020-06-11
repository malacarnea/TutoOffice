<?php

namespace App\Controller;

use App\Entity\Users;
use App\Services\FormationsListService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
//use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Flex\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
/**
 * @Security("is_granted('ROLE_USER')")
 */
class ProfileController extends AbstractController {

    private $em;

    public function __construct(EntityManagerInterface $manager) {
        $this->em = $manager;
    }

    /**
     * @Route("/profile", name="profile")
     */
    public function index() {
        return $this->render('site/profile/index.html.twig', [
                    'controller_name' => 'ProfileController',
        ]);
    }

    /**
     * @Route("/formations", name="formations")
     * @param FormationsListService $fls
     * @return Response
     */
    public function formations(FormationsListService $fls) {
        /** @var Users $user */
        $user = $this->getUser();
        //check access to formations
        $firstConnect = $user->getDateFirstConnect();
        $access = $user->getAccess();
        $now = new \DateTime();
        $checkDate=$firstConnect->add($access);
        $toSend=null;

        if ($checkDate > $now) {
            $formations = $user->getFormations();
            $toSend = $fls->getFormationsCT($formations);
        }

        return $this->render("site/profile/formations.html.twig", [
                    'formations' => $toSend,
                        ]
        );
    }

}
