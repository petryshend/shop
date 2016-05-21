<?php

namespace FrontEndBundle\Controller;

use BackEndBundle\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CategoryController extends Controller
{
    public function categoryPageAction(string $categoryName): Response
    {
        $category = $this->getDoctrine()
            ->getRepository('BackEndBundle:Category')
            ->findOneBy(['name' => $categoryName]);

        if (!$category) {
            return new Response(sprintf('Category %s not found', $categoryName), 404);
        }

        $products = $this->getDoctrine()
            ->getRepository('BackEndBundle:Product')
            ->findBy(['category' => $category]);

        $categories = $this->getAllCategories();

        return $this->render(
            'FrontEndBundle::category.html.twig',
            [
                'products' => $products,
                'categories' => $categories,
            ]
        );
    }
    
    public function categoriesDropdownAction(): Response
    {
        $categories = $this->getAllCategories();
        return $this->render(
            '@FrontEnd/partial/_categories_dropdown.html.twig',
            [
                'categories' => $categories,
            ]
        );
    }

    /**
     * @return Category[]
     */
    private function getAllCategories(): array
    {
        return $this->getDoctrine()
            ->getRepository('BackEndBundle:Category')
            ->findAll();
    }
}