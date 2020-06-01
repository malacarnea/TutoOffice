<?php

namespace App\Controller\Admin;

use App\Entity\Users;
use App\Form\UsersType;
use App\Services\PasswordGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/admin/users")
 */
class UsersController extends AbstractController {

    /**
     * @Route("/add", name="admin.users.add", methods={"GET","POST"})
     */
    public function add(Request $request, UserPasswordEncoderInterface $encoder): Response {
        $user = new Users();

        //call password generator and encode the password
        $form = $this->createForm(UsersType::class, $user);
        $form->handleRequest($request);

        //TODO send email here with the plain password
        if ($form->isSubmitted() && $form->isValid()) {
            $plainPassword= $request->request->get("users")['plainPassword'];
            $this->addFlash('success', "password : " . $plainPassword);
            $encoded = $encoder->encodePassword($user, $plainPassword);
            $user->setPassword($encoded);

//            $entityManager = $this->getDoctrine()->getManager();
//            $entityManager->persist($user);
//            $entityManager->flush();
            return new JsonResponse(["url" => "/admin#users-list"]);
        }

        return $this->render('site/admin/users/add.html.twig', [
                    'user' => $user,
                    'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin.users.show", methods={"GET"})
     */
    public function show(Users $user): Response {
        return $this->render('site/admin/users/show.html.twig', [
                    'user' => $user,
        ]);
    }

    /**
     * @Route("/edit/{id}", name="admin.users.edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Users $user): Response {
        $form = $this->createForm(UsersType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            return new JsonResponse(["url" => "/admin#users-list"]);
        }

        return $this->render('site/admin/users/edit.html.twig', [
                    'user' => $user,
                    'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin.users.delete", methods={"DELETE"})
     */
    public function delete(Request $request, Users $user): Response {
        if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }

        $url = $this->UsersIndexUrl();
        return $this->redirectToRoute($url);
    }

    protected function UsersIndexUrl() {
        return $this->generateUrl('admin.index', [
                    '_fragment' => 'users-list'
        ]);
    }

}
