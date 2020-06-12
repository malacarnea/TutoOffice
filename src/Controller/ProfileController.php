<?php

namespace App\Controller;

use App\Entity\Users;
use App\Form\ChangePasswordFormType;
use App\Services\FormationsListService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
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
    /**
     * @Route("/profile/reset-password", name="profile.reset_password")
     * @param FormationsListService $fls
     * @return Response
     */
    public function modifyPassword(Request $request, UserPasswordEncoderInterface $passwordEncoder){
          // The token is valid; allow the user to change their password.
        $user=$this->getUser();
        $form = $this->createForm(ChangePasswordFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // A password reset token should be used only once, remove it.
//            $this->resetPasswordHelper->removeResetRequest($token);

            // Encode the plain password, and set it.
            $encodedPassword = $passwordEncoder->encodePassword(
                $user,
                $form->get('plainPassword')->getData()
            );

            $user->setPassword($encodedPassword);
            $this->em->flush();

//            // The session is cleaned up after the password has been changed.
//            $this->cleanSessionAfterReset();
            $this->addFlash("success", "Votre mot de passe a bien été modifié.");
            return $this->redirectToRoute('profile');
        }
        return $this->render("reset_password/reset.html.twig", [
            'resetForm'=>$form->createView(),
        ]);
    }

}
