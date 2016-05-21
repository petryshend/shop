<?php

namespace FrontEndBundle\Controller;

use BackEndBundle\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    public function indexAction(): Response
    {
        $products = $this->getAllProducts();

        return $this->render(
            'FrontEndBundle::category.html.twig',
            [
                'products' => $products,
            ]
        );
    }

    public function productPageAction(int $id): Response
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
    private function getAllProducts(): array
    {
        return $this->getDoctrine()
            ->getRepository('BackEndBundle:Product')
            ->findAll();
    }
}