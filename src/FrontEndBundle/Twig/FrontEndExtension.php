<?php

namespace FrontEndBundle\Twig;

use Symfony\Component\DependencyInjection\Container;
use Twig_SimpleFilter;

class FrontEndExtension extends \Twig_Extension
{
    /** @var Container */
    private $container;
    
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * @return Twig_SimpleFilter[]
     */
    public function getFilters(): array
    {
        return [
            new Twig_SimpleFilter('rating', [$this, 'rating']),
            new Twig_SimpleFilter('price', [$this, 'price'])
        ];
    }

    public function rating($rating, $ratingsCount = 0): string
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

    public function price(float $price): string
    {
        return sprintf('%.2f &#8372;', $price);
    }

    public function getName(): string
    {
        return 'frontend_extension';
    }
}
