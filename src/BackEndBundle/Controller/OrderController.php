<?php

namespace BackEndBundle\Controller;

use BackEndBundle\Entity\Order;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class OrderController extends Controller
{
    public function listAction(): Response
    {
        $orders = $this->getDoctrine()->getRepository(Order::class)->findAll();
        
        return $this->render(
            '@BackEnd/order/list.html.twig',
            ['orders' => $orders]
        );
    }
}