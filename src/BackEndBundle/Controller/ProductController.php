<?php

namespace BackEndBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ProductController extends Controller
{
    public function listAction()
    {
        $products = $this->getDoctrine()
            ->getRepository('BackEndBundle:Product')
            ->findAll();

        return $this->render(
            'BackEndBundle:product:list.html.twig',
            [
                'products' => $products,
            ]
        );
    }
}
