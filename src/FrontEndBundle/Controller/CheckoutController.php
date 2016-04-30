<?php

namespace FrontEndBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckoutController extends Controller
{
    /**
     * @param Request $request
     * @return Response
     */
    public function cartPageAction(Request $request) : Response
    {
        $cartContents = json_decode($request->getSession()->get('cart'));
        return $this->render(
            '@FrontEnd/cart_page.html.twig',
            ['cart' => $cartContents]
        );
    }
}