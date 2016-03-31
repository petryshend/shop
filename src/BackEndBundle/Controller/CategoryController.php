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
    /** @var string[] */
    private $sortFields = ['id', 'name'];

    public function listAction(Request $request) : Response
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

    public function newAction(Request $request) : Response
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

    public function editAction(Request $request, $id) : Response
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

    public function deleteAction(Request $request) : RedirectResponse
    {
        $categoryId = $request->get('category_id');
        $category = $this->findCategory($categoryId);
        $em = $this->getDoctrine()->getManager();
        $em->remove($category);
        $em->flush();
        return $this->redirectToRoute('back_end_category_list');
    }

    private function findCategory(int $id) : Category
    {
        $category = $this->getDoctrine()
            ->getRepository('BackEndBundle:Category')
            ->find($id);

        if (null === $category) {
            throw $this->createNotFoundException(printf('Category with id %s not found', $id));
        }

        return $category;
    }

    private function persistCategory(Category $category)
    {
        $em = $this->getDoctrine()->getManager();
        $em->persist($category);
        $em->flush();
    }

    private function getSortField(Request $request) : string
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
