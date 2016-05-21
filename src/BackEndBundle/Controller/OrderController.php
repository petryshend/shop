<?php

namespace BackEndBundle\Controller;

use BackEndBundle\Entity\OrderInfo;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class OrderController extends Controller
{
    public function listAction()
    {
        $orders = $this->getDoctrine()->getRepository(OrderInfo::class)->findAll();
        dump($orders);die;
    }
}