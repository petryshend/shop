<?php

namespace BackEndBundle\Utils\ProductCrawler;

use Symfony\Component\DomCrawler\Crawler;

class ProductCrawler
{
    public function crawl(int $count = 1) : array
    {
        for ($i = 0; $i < $count; $i++) {
            $randCategoryKey = array_rand(HotlineCategories::getAsArray());
            $url = HotlineCategories::DOMAIN . HotlineCategories::getAsArray()[$randCategoryKey];
            $links = $this->getProductsLinks($url);
            $randProductKey = array_rand($links);
            $productInfo = $this->getRandomProductInfo(HotlineCategories::DOMAIN . $links[$randProductKey]);
        }
        return [];
    }

    private function getProductsLinks(string $url) : array
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

    private function getRandomProductInfo(string $url) : array
    {
        $html = file_get_contents($url);
        $crawler = new Crawler($html);
        $productTitle = $this->stripTagsFromProductTitle($crawler->filter('.title-main')->html());
        $productDescription = $this->stripNewlinesAndSpaces($crawler->filter('.full-desc')->text());
        dump($productDescription);die;
        return [];
    }

    private function stripTagsFromProductTitle(string $html) : string
    {
        $html = preg_replace('(<span\b[^>]*>(.*?)<\/span>)', '', $html);
        $html = preg_replace('(<div\b[^>]*>(.*?)<\/div>)', '', $html);
        return $this->stripNewlinesAndSpaces($html);
    }

    private function stripNewlinesAndSpaces(string $str) : string
    {
        $str = preg_replace('/\\n/', '', $str);
        $str = preg_replace('/\\t/', '', $str);
        return trim($str);
    }
}
