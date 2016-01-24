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
    /**
     * @return Response
     */
    public function listAction()
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

    /**
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function newAction(Request $request)
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

    public function editAction(Request $request, $id)
    {

    }

    public function deleteAction($id)
    {

    }

    /**
     * @param User $user
     */
    private function persistUser(User $user)
    {
        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();
    }
}