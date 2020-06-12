<?php

namespace App\Controller;

use App\Entity\Users;
use App\Services\FormationsListService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
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
    public function profile() {
        $user=$this->getUser();
        return $this->render('site/profile/profile.html.twig', [
                    'user' => $user,
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
        if (in_array("ROLE_ADMIN", $user->getRoles()) || in_array("ROLE_TEACHER", $user->getRoles())) {
            return $this->redirectToRoute("admin.index.formations");
        }

        //check access to formations
        $firstConnect = $user->getDateFirstConnect();

        $access = $user->getAccess();
        $now = new \DateTime();
        //if first connection, update date
        if ($firstConnect == null) {
            $user->setDateFirstConnect($now);
            $firstConnect = $now;
            $this->em->persist($user);
            $this->em->flush();
        }
        $firstConnect->add($access);
        $toSend = null;

        if ($firstConnect > $now) {
            $formations = $user->getFormations();
            $toSend = $fls->getFormationsCT($formations);
        }

        return $this->render("site/profile/formations.html.twig", [
                    'formations' => $toSend,
                        ]
        );
    }

}
