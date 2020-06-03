<?php

namespace App\Controller\Admin;

use App\Entity\Chapters;
use App\Entity\Formations;
use App\Form\ChaptersType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/chapters")
 */
class ChaptersController extends AbstractController {

    private $em;

    public function __construct(EntityManagerInterface $em) {
        $this->em = $em;
    }

    /**
     * @Route("/add", name="admin.chapters.add", methods={"GET","POST"})
     */
    public function add(Request $request): Response {
        $chapter = new Chapters();
        if ($request->request->has('id_parent')) {
            $id = intval($request->request->get('id_parent'));
            $formation = $this->em->getRepository(Formations::class)->find($id);
            $chapter->setFormation($formation);
        }
        $form = $this->createForm(ChaptersType::class, $chapter);
        //save data from submitted form
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $chapter = $form->getData();
            $this->em->persist($chapter);
            $this->em->flush();
            $this->addFlash('success', 'Le chapitre \'' . $chapter->getTitle() . '\' a bien été ajouté.');
            //redirection will be made with AJAX
            return new JsonResponse(["url" =>$this->generateUrl('admin.index.formations')]);
        }
        //render form
        return $this->render('site/admin/chapters/add.html.twig', [
                    'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/edit/{id}", name="admin.chapters.edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Chapters $chapter): Response {
        $form = $this->createForm(ChaptersType::class, $chapter);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash("success", "Le chapitre a bien été modifié.");
            return new JsonResponse(["url" =>$this->generateUrl('admin.index.formations')]);
        }
        return $this->render('site/admin/chapters/edit.html.twig', [
                    'chapter' => $chapter,
                    'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="admin.chapters.delete", methods={"DELETE"})
     */
    public function delete(Request $request, Chapters $chapter): Response {
        if ($this->isCsrfTokenValid('delete' . $chapter->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($chapter);
            $entityManager->flush();
            $this->addFlash("success", "Le chapitre a bien été supprimé.");
        }

        return $this->redirectToRoute('admin.index.formations');
    }

}
