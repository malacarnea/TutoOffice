<?php

namespace App\Controller;

use App\Entity\Chapters;
use App\Entity\Formations;
use App\Entity\Tutorials;
use App\Form\FormationsType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class AdminController extends AbstractController
{
    
    public function index()
    {
        $em=$this->getDoctrine()->getManager();
        //pour la mise en place des utilisateurs, il faudra checker si l'utilisateur peut 
        //bien suivre la formation et adapter la requete en fonction
        $toSend=Array();
        $formations=$em->getRepository(Formations::class)->findAll();
        //get chapters
        foreach ($formations as $formation){
            $chapters=$em->getRepository(Chapters::class)->findBy(["formation"=>$formation->getId()]);
            $temp_chap=Array();
            foreach ($chapters as $chapter){
                $tutorials=$em->getRepository(Tutorials::class)->findBy(["chapter"=>$chapter->getId()]);
                array_push($temp_chap, Array("chapter"=>$chapter, "tutorials"=>$tutorials));
            }
            array_push($toSend, Array("formation"=>$formation, "chapters"=>$temp_chap));
        }
        return $this->render('site/admin/index.html.twig', [
            'formations' => $toSend,
        ]);
    }
    
    public function addFormation(Request $request){
        $formation=new Formations();
        
        
        $form=$this->createForm(FormationsType::class, $formation);
        
        return $this->render('site/admin/addFormation.html.twig',[
                'form'=>$form->createView(),
            ]);
    }
    
    
    
    
}
