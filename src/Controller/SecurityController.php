<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use LogicException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


class SecurityController extends AbstractController {

    private $em;
    
    public function __construct(EntityManagerInterface $manager){
        $this->em=$manager;
    }
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response {
        $user = $this->getUser();
        $path = "";
        if ($user) {
            if ($this->isGranted('ROLE_ADMIN') || $this->isGranted('ROLE_TEACHER')) {
                $path = 'admin.index.formations';
            } else {
                $path = 'formations';
                //update firstConnect field
                if($user->getDateFirstConnect()===null){
                    $now=new \DateTime();
                    $user->setDateFirstConnect($now);
                    $this->em->persist($user);
                    $this->em->flush();
                }
            }
            return $this->redirectToRoute($path);
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout() {
        throw new LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

}
