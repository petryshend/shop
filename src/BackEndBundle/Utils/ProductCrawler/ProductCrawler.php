<?php

namespace BackEndBundle\Utils\ProductCrawler;

use BackEndBundle\Entity\Category;
use BackEndBundle\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;
use InvalidArgumentException;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\DomCrawler\Crawler;

class ProductCrawler
{
    /** @var EntityManagerInterface */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function crawlProduct(): Product
    {
        $randCategoryKey = array_rand(HotlineCategories::getAsArray());
        $selectedHotlineCategory = HotlineCategories::getAsArray()[$randCategoryKey];
        $url = HotlineCategories::DOMAIN . HotlineCategories::getAsArray()[$randCategoryKey];
        $links = $this->getProductsLinks($url);
        $randProductKey = array_rand($links);
        $productInfo = $this->getRandomProductInfo(HotlineCategories::DOMAIN . $links[$randProductKey]);
        $productName = trim(strip_tags($productInfo['name']));

        if ($this->productExists($productName)) {
            throw new Exception(sprintf('Sorry, but %s already exists in database', $productName));
        }

        $product = new Product();
        $product->setName($productName);
        $product->setDescription($productInfo['description']);
        $product->setPrice($productInfo['price']);
        $product->setImageUrl($productInfo['image']);

        $categoryName = HotlineCategories::getMappingsToActualCategories()[$selectedHotlineCategory];
        $category = $this->getCategoryForProduct($categoryName);
        if ($category === null) {
            throw new EntityNotFoundException(sprintf('There is no category %s in database', $categoryName));
        }
        $product->setCategory($category);

        return $product;
    }

    private function getProductsLinks(string $url): array
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

    private function getRandomProductInfo(string $url): array
    {
        $html = file_get_contents($url);
        $crawler = new Crawler($html);
        $productName = $this->stripTagsFromProductTitle($crawler->filter('.title-main')->html());
        $productDescription = $this->stripNewlinesAndSpaces($crawler->filter('.full-desc')->text());
        $productPrice = $crawler->filter('.range-price strong');
        try {
            $productPrice = $this->getNumericPriceFromHTML($productPrice->html());
        } catch (InvalidArgumentException $ex) {
            // TODO: Log this
            die(sprintf('There was a problem while getting price for %s. \nTherefore Abort.', $productName));
        }
        $productImage = $crawler->filter('img.g_statistic')->attr('src');

        return [
            'name' => $productName,
            'description' => $productDescription,
            'price' => $productPrice,
            'image' => HotlineCategories::DOMAIN.  $productImage,
        ];
    }

    private function getNumericPriceFromHTML(string $html): int
    {
        $price = $this->stripTagsFromProductTitle($html);
        $price = $this->stripNewlinesAndSpaces($price);
        return $this->extractProductPrice($price);
    }

    private function stripTagsFromProductTitle(string $html): string
    {
        $html = preg_replace('(<span\b[^>]*>(.*?)<\/span>)', '', $html);
        $html = preg_replace('(<div\b[^>]*>(.*?)<\/div>)', '', $html);
        return $this->stripNewlinesAndSpaces($html);
    }

    private function stripNewlinesAndSpaces(string $str): string
    {
        $str = preg_replace('/\\n/', '', $str);
        $str = preg_replace('/\\t/', '', $str);
        return trim($str);
    }

    private function extractProductPrice(string $stringPrice): int
    {
        list($priceLow, $priceHigh) = explode('–', $stringPrice);
        // Get rid of special characters in price string and cast it to int
        $priceLow = intval(str_replace('+AKA-', '', mb_convert_encoding(trim($priceLow), 'UTF-7')));
        $priceHigh = intval(str_replace('+AKA-', '', mb_convert_encoding(trim($priceHigh), 'UTF-7')));
        return ($priceLow + $priceHigh) / 2;
    }

    private function getCategoryForProduct(string $categoryName): Category
    {
        $category = $this->entityManager
            ->getRepository(Category::class)
            ->findOneBy(['name' => $categoryName]);
        return $category;
    }

    private function productExists(string $productName): bool
    {
        $product = $this->entityManager
            ->getRepository(Product::class)
            ->findOneBy(['name' => $productName]);
        if ($product === null) {
            return false;
        }
        return true;
    }
}
