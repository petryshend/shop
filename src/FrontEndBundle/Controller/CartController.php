<?php

namespace FrontEndBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

class CartController extends Controller
{
    public function addToCartAction(Request $request)
    {
        $session = $request->getSession();

        $session->set('name', 'Emanuil');

        return new Response('Name set');
    }

    public function getCartAction(Request $request)
    {
        $session = $request->getSession();

        return new Response($session->get('name'));
    }
}