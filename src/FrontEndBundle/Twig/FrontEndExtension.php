<?php

namespace FrontEndBundle\Twig;

use Symfony\Component\DependencyInjection\Container;
use Twig_SimpleFilter;

class FrontEndExtension extends \Twig_Extension
{
    /** @var Container */
    private $container;

    /**
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * @return Twig_SimpleFilter[]
     */
    public function getFilters()
    {
        return [
            new Twig_SimpleFilter('rating', [$this, 'rating']),
            new Twig_SimpleFilter('price', [$this, 'price'])
        ];
    }

    /**
     * @param int $rating
     * @return string
     */
    public function rating($rating, $ratingsCount = 0)
    {
        $html = '';
        for ($i = 0; $i < $rating; $i++) {
            $html .= '<span class="glyphicon glyphicon-star star-filled"></span>';
        }
        for ($i = 0; $i < 5 - $rating; $i++) {
            $html .= '<span class="glyphicon glyphicon-star star-not-filled"></span>';
        }
        if (!$ratingsCount) {
            $html .= '<span class="ratings-count">(No ratings)</span>';
        } else {
            $html .= sprintf('<span class="ratings-count">(%d)</span>', $ratingsCount);
        }

        return $html;
    }

    /**
     * @param $price
     * @return string
     */
    public function price($price)
    {
        return sprintf('%.2f &#8372;', $price);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'frontend_extension';
    }
}
