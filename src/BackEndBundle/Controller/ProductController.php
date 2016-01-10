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
    /**
     * @return Response
     */
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

    /**
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function newAction(Request $request)
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);
        if ($form->isValid()) {
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
     * @param Product $product
     */
    private function persistProduct(Product $product)
    {
        $em = $this->getDoctrine()->getManager();
        $em->persist($product);
        $em->flush();
    }
}
