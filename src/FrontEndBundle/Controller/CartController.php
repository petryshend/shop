<?php

namespace FrontEndBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

class CartController extends Controller
{
    /**
     * @param Request $request
     * @return Response
     */
    public function addToCartAction(Request $request) : Response
    {
        $session = $request->getSession();
        $productId = $request->get('productId');
        $productName = $request->get('productName');
        $quantity = intval($request->get('quantity'));
        $cartItems = json_decode($session->get('cart'), true);

        if (!$cartItems) {
            $cartItems = [];
        }
        $cartProductIds = array_map(function($entry) {
            return $entry['productId'];
        }, $cartItems);

        $key = array_search($productId, $cartProductIds);
        if ($key !== false) {
            $cartItems[$key]['quantity'] = intval($cartItems[$key]['quantity']) + 1;
        } else {
            array_push($cartItems,
                [
                    'productId' => $productId,
                    'productName' => $productName,
                    'quantity' => $quantity
                ]
            );
        }

        $updatedItems = json_encode($cartItems);

        $session->set('cart', $updatedItems);

        return new Response('Item added');
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function getCartAction(Request $request) : Response
    {
        $session = $request->getSession();
        return new Response($session->get('cart'));
    }
}