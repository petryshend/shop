<?php

namespace BackEndBundle\Controller;

use BackEndBundle\Entity\Category;
use BackEndBundle\Form\CategoryType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends Controller
{
    /**-
     * @return Response
     */
    public function listAction()
    {
        $categories = $this->getDoctrine()
            ->getRepository('BackEndBundle:Category')
            ->findAll();

        return $this->render(
            '@BackEnd/category/list.html.twig',
            [
                'categories' => $categories,
            ]
        );
    }

    /**
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function newAction(Request $request)
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->persistCategory($category);
            return $this->redirectToRoute('back_end_category_list');
        }
        return $this->render(
            '@BackEnd/category/new.html.twig',
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
        $category = $this->findCategory($id);

        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->persistCategory($category);
            return $this->redirectToRoute('back_end_category_list');
        }

        return $this->render(
            '@BackEnd/category/new.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * @param int $id
     * @return RedirectResponse
     */
    public function deleteAction($id)
    {
        $category = $this->findCategory($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($category);
        $em->flush();
        return $this->redirectToRoute('back_end_category_list');
    }

    /**
     * @param int $id
     * @return Category
     */
    private function findCategory($id)
    {
        $category = $this->getDoctrine()
            ->getRepository('BackEndBundle:Category')
            ->find($id);

        if (null === $category) {
            throw $this->createNotFoundException(printf('Category with id %s not found', $id));
        }

        return $category;
    }

    /**
     * @param Category $category
     */
    private function persistCategory(Category $category)
    {
        $em = $this->getDoctrine()->getManager();
        $em->persist($category);
        $em->flush();
    }
}