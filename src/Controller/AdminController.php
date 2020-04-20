<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{
    
    public function index()
    {
        return $this->render('site/admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }
    
    
}
