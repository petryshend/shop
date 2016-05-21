<?php

namespace BackEndBundle\Twig;

use BackEndBundle\Entity\Product;
use Doctrine\ORM\PersistentCollection;
use Symfony\Component\DependencyInjection\Container;

class BackEndExtension extends \Twig_Extension
{
    /** @var Container */
    private $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function getFilters(): array
    {
        return [
            new \Twig_SimpleFilter('active', [$this, 'isActiveLink']),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new \Twig_SimpleFunction('getOrderTotal', [$this, 'getOrderTotal']),
        ];
    }

    public function isActiveLink(string $route): bool
    {
        $currentRoute = $this->container->get('request_stack')->getCurrentRequest()->get('_route');
        return $currentRoute == $route;
    }

    public function getOrderTotal(PersistentCollection $orderItems): float
    {
        $total = 0;
        foreach ($orderItems as $item) {
            $product = $this->container->get('doctrine')->getRepository(Product::class)->find($item->getProductId());
            $total += (int)$item->getQuantity() * $product->getPrice();
        }
        return $total;
    }
    
    public function getName(): string
    {
        return 'backend_extension';
    }
}