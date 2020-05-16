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

class AdminController extends AbstractController {

    public function index() {
        $em = $this->getDoctrine()->getManager();
        //pour la mise en place des utilisateurs, il faudra checker si l'utilisateur peut 
        //bien suivre la formation et adapter la requete en fonction
        $toSend = Array();
        $formations = $em->getRepository(Formations::class)->findAll();
        //get chapters
        foreach ($formations as $formation) {
            $chapters = $em->getRepository(Chapters::class)->findBy(["formation" => $formation->getId()]);
            $temp_chap = Array();
            foreach ($chapters as $chapter) {
                $tutorials = $em->getRepository(Tutorials::class)->findBy(["chapter" => $chapter->getId()]);
                array_push($temp_chap, Array("chapter" => $chapter, "tutorials" => $tutorials));
            }
            array_push($toSend, Array("formation" => $formation, "chapters" => $temp_chap));
        }
        return $this->render('site/admin/index.html.twig', [
                    'formations' => $toSend,
        ]);
    }


    public function addFormation(Request $request) {

        $title = "Nouvelle Formation";
        $formation = new Formations();
        $form = $this->createForm(FormationsType::class, $formation);

        //save data from submitted form
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $formation = $form->getData();
            $em = $this->getDoctrine()->getManager();
             $em->persist($formation);
             $em->flush();
            $this->addFlash('success', 'La formation \'' . $formation->getTitle() . '\' a bien été ajoutée.');
            return $this->redirectToRoute('admin');
        }
        //render form
        return $this->render('site/admin/add.html.twig', [
                    'form' => $form->createView(),
                    'title' => $title,
                    'target' => '/admin/add/formation'
        ]);
    }
    
     public function addChapter(Request $request) {

        $title = "Nouveau Chapitre";
        $chapter = new Chapters();
        $id=intval($request->request->get('id_parent'));
        $em = $this->getDoctrine()->getManager();
        $formation=$em->getRepository(Formations::class).find($id);
        $form = $this->createForm(ChaptersType::class, $chapter, ['id' => $id]);
        
        //save data from submitted form
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $chapter = $form->getData();
            
            $em->persist($chapter);
            $em->flush();
            $this->addFlash('success', 'Le chapitre \'' . $chapter->getTitle() . '\' a bien été ajouté.');
            return $this->redirectToRoute('admin');
        }
        //render form
        return $this->render('site/admin/add.html.twig', [
                    'form' => $form->createView(),
                    'title' => $title,
                    'target' => '/admin/add/chapter'
        ]);
    }
    
       public function addTutorial(Request $request) {

        $title = "Nouveau Tutoriel";
        $tuto = new Tutorials();
        $form = $this->createForm(TutorialsType::class, $tuto, ['id' => intval($request->request->get('id_parent'))]);

        //save data from submitted form
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $tuto = $form->getData();
            $em = $this->getDoctrine()->getManager();
             $em->persist($tuto);
             $em->flush();
             $this->addFlash('success', 'Le tutoriel \'' . $tuto->getTitle() . '\' a bien été ajouté.');
            return $this->redirectToRoute('admin');
        }
        //render form
        return $this->render('site/admin/add.html.twig', [
                    'form' => $form->createView(),
                    'title' => $title,
                    'target' => '/admin/add/tutorial'
        ]);
       }

}
