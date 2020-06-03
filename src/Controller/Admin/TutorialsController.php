<?php

namespace App\Controller\Admin;

use App\Entity\Chapters;
use App\Entity\Tutorials;
use App\Form\TutorialsType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/tutorials")
 */
class TutorialsController extends AbstractController {

    private $em;

    public function __construct(EntityManagerInterface $em) {
        $this->em = $em;
    }

    /**
     * @Route("/add", name="admin.tutorials.add", methods={"GET","POST"})
     */
    public function add(Request $request): Response {
        $tuto = new Tutorials();
        if ($request->request->has('id_parent')) {
            $id = intval($request->request->get('id_parent'));
            $chapter = $this->em->getRepository(Chapters::class)->find($id);
            $tuto->setChapter($chapter);
        }
        $form = $this->createForm(TutorialsType::class, $tuto);

        //save data from submitted form
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $tuto = $form->getData();
            $this->em->persist($tuto);
            $this->em->flush();
            $this->addFlash('success', 'Le tutoriel \'' . $tuto->getTitle() . '\' a bien été ajouté.');
            return new JsonResponse(["url" =>$this->generateUrl('admin.index.formations')]);
        }
        //render form
        return $this->render('site/admin/tutorials/add.html.twig', [
                    'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/edit/{id}", name="admin.tutorials.edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Tutorials $tutorial): Response {
        $form = $this->createForm(TutorialsType::class, $tutorial);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'Le tutoriel \'' . $tutorial->getTitle() . '\' a bien été modifié.');
            return new JsonResponse(["url" =>$this->generateUrl('admin.index.formations')]);
        }
        return $this->render('/site/admin/tutorials/edit.html.twig', [
                    'tutorial' => $tutorial,
                    'form' => $form->createView(),
        ]);

    }

    /**
     * @Route("/delete/{id}", name="admin.tutorials.delete", methods={"DELETE"})
     */
    public function delete(Request $request, Tutorials $tutorial): Response {
        if ($this->isCsrfTokenValid('delete' . $tutorial->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($tutorial);
            $entityManager->flush();
            $this->addFlash('success', 'Le tutoriel a bien été supprimé.');
        }

        return $this->redirectToRoute('admin.index.formations');
    }

}
