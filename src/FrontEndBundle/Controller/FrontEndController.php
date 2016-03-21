<?php

namespace FrontEndBundle\Controller;

use BackEndBundle\Entity\Category;
use BackEndBundle\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class FrontEndController extends Controller
{
    /**
     * @return Response
     */
    public function indexAction()
    {
        $products = $this->getAllProducts();
        $categories = $this->getAllCategories();

        return $this->render(
            'FrontEndBundle::index.html.twig',
            [
                'products' => $products,
                'categories' => $categories,
            ]
        );
    }

    /**
     * @param $categoryName
     * @return Response|NotFoundHttpException
     */
    public function categoryPageAction($categoryName)
    {
        $category = $this->getDoctrine()
            ->getRepository('BackEndBundle:Category')
            ->findOneBy(['name' => $categoryName]);

        if (!$category) {
            return new Response(sprintf('Category %s not found', $categoryName), 404);
        }

        $products = $this->getDoctrine()
            ->getRepository('BackEndBundle:Product')
            ->findBy(['category' => $category]);

        $categories = $this->getAllCategories();

        return $this->render(
            'FrontEndBundle::category.html.twig',
            [
                'products' => $products,
                'categories' => $categories,
                'category' => $category
            ]
        );
    }

    /**
     * @param int $id
     * @return Response
     */
    public function productPageAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $product = $em->find('BackEndBundle:Product', $id);
        return $this->render(
            'FrontEndBundle::product.html.twig',
            [
                'product' => $product,
            ]
        );
    }

    /**
     * @return Product[]
     */
    private function getAllProducts()
    {
        return $this->getDoctrine()
            ->getRepository('BackEndBundle:Product')
            ->findAll();
    }

    /**
     * @return Category[]
     */
    private function getAllCategories()
    {
        return $this->getDoctrine()
            ->getRepository('BackEndBundle:Category')
            ->findAll();
    }
}
