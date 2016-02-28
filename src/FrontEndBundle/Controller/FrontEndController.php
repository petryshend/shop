<?php

namespace FrontEndBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class FrontEndController extends Controller
{
    /**
     * @return Response
     */
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
