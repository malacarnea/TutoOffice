<?php

namespace App\Controller;

use App\Entity\Chapters;
use App\Entity\Formations;
use App\Entity\Tutorials;
use App\Form\ChaptersType;
use App\Form\FormationsType;
use App\Form\TutorialsType;
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
    
    public function add(Request $request){
        if(isset($request->request)){
            switch($request->request->get('entity')){
                case 'formations':
                    $title="Nouvelle Formation";
                    $formation=new Formations();
                    $form=$this->createForm(FormationsType::class, $formation);
                    break;
                case 'chapters':
                     $title="Ajouter un chapitre";
                    $chapter=new Chapters();
                    //create form with formation id pasted in parameter
                    $form=$this->createForm(ChaptersType::class, $chapter, ['id'=>intval($request->request->get('id_parent'))]);
                    break;
                case 'tutorials':
                 $title="Ajouter un tutoriel";
                    $tuto=new Tutorials();
                    $form=$this->createForm(TutorialsType::class, $tuto, ['id'=>intval($request->request->get('id_parent'))]);
                    break;
            }
        }
        
        
        
        return $this->render('site/admin/add.html.twig',[
                'form'=>$form->createView(),
                'title'=>$title,
            ]);
    }
    
    
    
    
}
