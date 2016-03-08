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
}
