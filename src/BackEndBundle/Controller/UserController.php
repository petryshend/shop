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

    /**
     * @param Request $request
     * @param int $id
     * @return RedirectResponse|Response
     */
    public function editAction(Request $request, $id)
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

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function deleteAction(Request $request)
    {
        $userId = $request->get('user_id');
        $user = $this->findUser($userId);
        $em = $this->getDoctrine()->getManager();
        $em->remove($user);
        $em->flush();
        return $this->redirectToRoute('back_end_user_list');
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

    private function findUser($id)
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
