<?php

namespace App\Controller\Admin;

use App\Entity\Formations;
use App\Form\FormationsType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/admin/formations")
 * @Security("is_granted('ROLE_ADMIN')")
 */
class FormationsController extends AbstractController {

    private $em;

    public function __construct(EntityManagerInterface $em) {
        $this->em = $em;
    }

    /**
     * @Route("/add", name="admin.formations.add", methods={"GET","POST"})
     */
    public function add(Request $request) {
        $formation = new Formations();
        $form = $this->createForm(FormationsType::class, $formation);
        //save data from submitted form
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $formation = $form->getData();
            $this->em->persist($formation);
            $this->em->flush();
            $this->addFlash('success', 'La formation \'' . $formation->getTitle() . '\' a bien été ajoutée.');
            return new JsonResponse(["url" =>$this->generateUrl('admin.index.formations')]);
        }
        //render form
        return $this->render('site/admin/formations/add.html.twig', [
                    'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/edit/{id}", name="admin.formations.edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Formations $formation): Response {
        $form = $this->createForm(FormationsType::class, $formation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return new JsonResponse(["url" =>$this->generateUrl('admin.index.formations')]);
        }

        return $this->render('site/admin/formations/edit.html.twig', [
                    'formation' => $formation,
                    'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin.formations.delete", methods={"DELETE"})
     */
    public function delete(Request $request, Formations $formation): Response {
        if ($this->isCsrfTokenValid('delete' . $formation->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($formation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin.index.formations');
    }

}
