<?php

namespace FrontEndBundle\Controller;

use BackEndBundle\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    /**
     * @return Response
     */
    public function indexAction() : Response
    {
        $products = $this->getAllProducts();

        return $this->render(
            'FrontEndBundle::index.html.twig',
            [
                'products' => $products,
            ]
        );
    }

    /**
     * @param int $id
     * @return Response
     */
    public function productPageAction($id) : Response
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
    private function getAllProducts() : array
    {
        return $this->getDoctrine()
            ->getRepository('BackEndBundle:Product')
            ->findAll();
    }
}