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
    /** @var string */
    private $sortFields = ['id', 'name'];

    /**-
     * @param Request $request
     * @return Response
     */
    public function listAction(Request $request)
    {
        if (!$page = $request->get('page')) {
            $page = 1;
        }

        $sortOrder = $request->get('direction') === 'desc' ? 'desc' : 'asc';
        $sortField = $this->getSortField($request);

        $categories = $this->getDoctrine()
            ->getRepository('BackEndBundle:Category')
            ->findBy([], [$sortField => $sortOrder]);

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($categories, $page, 5);

        return $this->render(
            '@BackEnd/category/list.html.twig',
            [
                'pagination' => $pagination,
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
     * @param Request $request
     * @return RedirectResponse
     */
    public function deleteAction(Request $request)
    {
        $categoryId = $request->get('category_id');
        $category = $this->findCategory($categoryId);
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

    /**
     * @param Request $request
     * @return string
     */
    private function getSortField($request)
    {
        $sortField = 'id';
        if ($request->get('sort')) {
            $sortField = explode('.', $request->get('sort'))[1];
        }
        if (in_array($sortField, $this->sortFields)) {
            return $sortField;
        }
        return $sortField;
    }
}