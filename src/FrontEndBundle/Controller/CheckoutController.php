<?php

namespace FrontEndBundle\Controller;

use BackEndBundle\Entity\Order;
use BackEndBundle\Entity\OrderInfo;
use BackEndBundle\Entity\OrderItem;
use BackEndBundle\Entity\Product;
use BackEndBundle\Form\OrderInfoType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckoutController extends Controller
{
    public function cartPageAction(Request $request): Response
    {
        $cartContents = json_decode($request->getSession()->get('cart'));
        return $this->render(
            '@FrontEnd/cart_page.html.twig',
            ['cart' => $cartContents]
        );
    }

    public function orderInfoPageAction(Request $request): Response
    {
        $orderInfo = new OrderInfo();
        $form = $this->createForm(OrderInfoType::class, $orderInfo);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $order = new Order();
            $orderInfo->setOrder($order);
            $order->setOrderInfo($orderInfo);
            $orderItems = $this->createOrderItemsFromCart($request->getSession()->get('cart'));
            $em = $this->getDoctrine()->getManager();
            foreach ($orderItems as $orderItem) {
                $orderItem->setOrder($order);
                $em->persist($orderItem);
                $order->addOrderItem($orderItem);
            }
            $em->persist($orderInfo);
            $em->persist($order);
            $em->flush();

            $request->getSession()->set('cart', null);
            $request->getSession()->set('checkout_complete', true);
            return $this->redirectToRoute('front_end_checkout_complete_page');
        }
        
        return $this->render(
            '@FrontEnd/order_info_page.html.twig',
            [
                'form' => $form->createView(),
            ]  
        );
    }

    public function checkoutCompletePageAction(Request $request): Response
    {
        if ($request->getSession()->get('checkout_complete')) {
            $request->getSession()->set('checkout_complete', null);
            return $this->render('@FrontEnd/checkout_complete.html.twig');
        }
        return $this->redirectToRoute('front_end_homepage');
    }

    /**
     * @param string $cart
     * @return OrderItem[]
     */
    private function createOrderItemsFromCart(string $cart): array
    {
        $orderItems = [];
        $cart = json_decode($cart);
        foreach ($cart as $item) {
            $orderItem = new OrderItem();
            $product = $this->getDoctrine()->getRepository(Product::class)->find($item->productId);
            $orderItem->setProductId($product->getId());
            $orderItem->setQuantity($item->quantity);
            $orderItems[] = $orderItem;
        }
        
        return $orderItems;
    }
}