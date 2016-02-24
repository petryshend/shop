<?php

namespace BackEndBundle\DataFixtures\ORM;

use BackEndBundle\Entity\Product;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadProductsData extends AbstractFixture implements OrderedFixtureInterface
{
    const PRODUCTS_COUNT = 30;

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < self::PRODUCTS_COUNT; $i++) {
            $product = new Product();
            $product->setName('Product ' . $i);
            $product->setDescription('Description of product ' . $i);
            $product->setPrice(mt_rand(1 * 100, 9 * 100) / 100);
            $product->setCategory(
                $this->getReference('category' . mt_rand(0, LoadCategoriesData::CATEGORIES_COUNT - 1))
            );
            $product->setImageUrl('http://placehold.it/300x300');

            $manager->persist($product);
            $manager->flush();
        }
    }

    public function getOrder()
    {
        return 30;
    }
}
