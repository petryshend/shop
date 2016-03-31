<?php

namespace BackEndBundle\Utils\ProductCrawler;

use Symfony\Component\DomCrawler\Crawler;

class ProductCrawler
{
    public function crawl($count = 1)
    {
        for ($i = 0; $i < $count; $i++) {
            $randKey = array_rand(HotlineCategories::getAsArray());
            $url = HotlineCategories::DOMAIN . HotlineCategories::getAsArray()[$randKey];
            $links = $this->getProductsLinks($url);
            dump($links);die;
        }
        return [];
    }

    /**
     * @param string $url
     * @return \string[]
     */
    private function getProductsLinks($url)
    {
        $links = [];
        $html = file_get_contents($url);
        $crawler = new Crawler($html);
        $productsLinks = $crawler->filter('.ttle .g_statistic');
        foreach($productsLinks as $node) {
            $linkNode = new Crawler($node);
            $links[] = $linkNode->attr('href');
        }
        return $links;
    }
}
