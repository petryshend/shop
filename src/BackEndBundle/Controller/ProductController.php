<?php

namespace BackEndBundle\Controller;

use BackEndBundle\Entity\Product;
use BackEndBundle\Form\ProductType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    /** @var string[] */
    private $sortFiels = ['id', 'name', 'category', 'rating', 'price'];

    /**
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

        $products = $this->getDoctrine()
            ->getRepository('BackEndBundle:Product')
            ->findBy([], [$sortField => $sortOrder]);

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($products, $page, 5);

        return $this->render(
            'BackEndBundle:product:list.html.twig',
            [
                'products' => $products,
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
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->persistProduct($product);
            return $this->redirectToRoute('back_end_product_list');
        }
        return $this->render(
            '@BackEnd/product/new.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function editAction(Request $request, $id)
    {
        $product = $this->findProduct($id);

        $form = $this->createForm(ProductType::class, $product);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->persistProduct($product);
            return $this->redirectToRoute('back_end_product_list');
        }

        return $this->render(
            '@BackEnd/product/new.html.twig',
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
        $productId = $request->get('product_id');

        $product = $this->findProduct($productId);
        $em = $this->getDoctrine()->getManager();
        $em->remove($product);
        $em->flush();
        return $this->redirectToRoute('back_end_product_list');
    }

    /**
     * @param int $id
     * @return Product
     */
    private function findProduct($id)
    {
        $product = $this->getDoctrine()
            ->getRepository('BackEndBundle:Product')
            ->find($id);

        if (null === $product) {
            throw  $this->createNotFoundException(printf('Product with id %s not found', $id));
        }

        return $product;
    }

    /**
     * @param Product $product
     */
    private function persistProduct(Product $product)
    {
        $em = $this->getDoctrine()->getManager();
        $em->persist($product);
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
        if (in_array($sortField, $this->sortFiels)) {
            return $sortField;
        }
        return $sortField;
    }
}
