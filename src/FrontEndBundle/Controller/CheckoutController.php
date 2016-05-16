<?php

namespace FrontEndBundle\Controller;

use BackEndBundle\Entity\OrderInfo;
use BackEndBundle\Form\OrderInfoType;
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

    /**
     * @param Request $request
     * @return Response
     */
    public function orderInfoPageAction(Request $request)
    {
        $orderInfo = new OrderInfo();
        $form = $this->createForm(OrderInfoType::class, $orderInfo);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->persistOrderInfo($orderInfo);
            $this->clearCart($request);
            return $this->redirectToRoute('front_end_checkout_complete_page');
        }
        
        return $this->render(
            '@FrontEnd/order_info_page.html.twig',
            [
                'form' => $form->createView(),
            ]  
        );
    }

    /**
     * @return Response
     */
    public function checkoutCompletePageAction()
    {
        return $this->render('@FrontEnd/checkout_complete.html.twig');
    }

    /**
     * @param OrderInfo $orderInfo
     */
    private function persistOrderInfo(OrderInfo $orderInfo)
    {
        $em = $this->getDoctrine()->getManager();
        $em->persist($orderInfo);
        $em->flush();
    }

    /**
     * @param Request $request
     */
    private function clearCart(Request $request)
    {
        $session = $request->getSession();
        $session->clear();
    }
}