<?php

namespace BackEndBundle\Twig;

use Symfony\Component\DependencyInjection\Container;

class BackEndExtension extends \Twig_Extension
{
    /** @var Container  */
    private $container;

    /**
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * @return array
     */
    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('active', [$this, 'isActiveLink'])
        ];
    }

    /**
     * @param string $route
     * @return bool
     * @throws \Exception
     */
    public function isActiveLink($route)
    {
        $currentRoute = $this->container->get('request_stack')->getCurrentRequest()->get('_route');
        return $currentRoute == $route;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'backend_extension';
    }
}