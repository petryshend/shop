<?php

namespace BackEndBundle\Utils\ProductCrawler;

use InvalidArgumentException;
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
        try {
            $productPrice = $this->extractProductPrice($crawler->filter('.range-price strong')->html());
        } catch (InvalidArgumentException $ex) {
            // TODO: Log this
            die(sprintf('There was a problem while getting price for %s. \nTherefore Abort.', $productTitle));
        }
        
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

    private function extractProductPrice(string $stringPrice) : int
    {
        list($priceLow, $priceHigh) = explode('–', $stringPrice);
        // Get rid of special characters in price string and cast it to int
        $priceLow = intval(str_replace('+AKA-', '', mb_convert_encoding(trim($priceLow), 'UTF-7')));
        $priceHigh = intval(str_replace('+AKA-', '', mb_convert_encoding(trim($priceHigh), 'UTF-7')));
        return ($priceLow + $priceHigh) / 2;
    }
}
