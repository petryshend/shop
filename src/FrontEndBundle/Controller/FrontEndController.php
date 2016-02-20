<?php

namespace FrontEndBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class FrontEndController extends Controller
{
    public function indexAction()
    {
        $products = $this->getDoctrine()
            ->getRepository('BackEndBundle:Product')
            ->findAll();

        return $this->render(
            'FrontEndBundle::index.html.twig',
            [
                'products' => $products,
            ]
        );
    }
}
