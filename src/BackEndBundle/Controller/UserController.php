<?php

namespace BackEndBundle\Controller;

use BackEndBundle\Entity\User;
use BackEndBundle\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function listAction(): Response
    {
        $users = $this->getDoctrine()
            ->getRepository('BackEndBundle:User')
            ->findAll();

        return $this->render(
            '@BackEnd/user/list.html.twig',
            [
                'users' => $users,
            ]
        );
    }

    public function newAction(Request $request): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->persistUser($user);
            return $this->redirectToRoute('back_end_user_list');
        }
        return $this->render(
            '@BackEnd/user/new.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }

    public function editAction(Request $request, int $id): Response
    {
        $user = $this->findUser($id);

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->persistUser($user);
            return $this->redirectToRoute('back_end_user_list');
        }
        return $this->render(
            '@BackEnd/user/new.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }

    public function deleteAction(Request $request): Response
    {
        $userId = $request->get('user_id');
        $user = $this->findUser($userId);
        $em = $this->getDoctrine()->getManager();
        $em->remove($user);
        $em->flush();
        return $this->redirectToRoute('back_end_user_list');
    }
    
    private function persistUser(User $user)
    {
        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();
    }

    private function findUser(int $id): User
    {
        $user = $this->getDoctrine()
            ->getRepository('BackEndBundle:User')
            ->find($id);

        if (null == $user) {
            throw $this->createNotFoundException(printf('User with id %s not found', $id));
        }

        return $user;
    }
}
