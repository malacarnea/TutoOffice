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
            'controller_name' => 'SiteController',
        ]);
    }
    
    /**
     * @Route("/connection", name="connection")
     * @return type
     */
     public function connection()
    {
        return $this->render('site/connexion.html.twig', [
            'controller_name' => 'SiteController',
        ]);
    }
}
