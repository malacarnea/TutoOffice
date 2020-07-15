<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class SiteController extends AbstractController
{
    
    /**
     * @Route("/", name="accueil")
     * @return type
     */
    public function index()
    {
        return $this->render('site/index.html.twig', [
            'controller_action' => 'index',
            'error'=>null,
        ]);
    }
    
    
    /**
     * @Route("/apropos", name="apropos")
     * @return type
     */
     public function apropos()
    {
        return $this->render('site/apropos.html.twig', [
            'controller_action' => 'apropos',
        ]);
    }
    
    /**
     * @Route("/legal-notice", name="legal-notice")
     * @return type
     */
     public function legal_notice()
    {
        return $this->render('site/legal_notice.html.twig', [
            'controller_action' => 'legal-notice',
        ]);
    }
    
    /**
     * @Route("/rules", name="rules")
     * @return type
     */
    public function rules(){
        return $this->render('site/rules.html.twig',[
            'controller_action'=>'rules',
        ]);
    }
}
