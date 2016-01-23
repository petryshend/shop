<?php

namespace BackEndBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function listAction()
    {
        return new Response('User List Action');
    }

    public function newAction(Request $request)
    {

    }

    public function editAction(Request $request, $id)
    {

    }

    public function deleteAction($id)
    {

    }
}