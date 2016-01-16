<?php

namespace BackEndBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends Controller
{
    /**-
     * @return Response
     */
    public function listAction()
    {
        $categories = $this->getDoctrine()
            ->getRepository('BackEndBundle:Category')
            ->findAll();

        return $this->render(
            '@BackEnd/category/list.html.twig',
            [
                'categories' => $categories,
            ]
        );
    }
}