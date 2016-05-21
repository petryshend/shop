<?php

namespace BackEndBundle\DataFixtures\ORM;

use BackEndBundle\Entity\Category;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadCategoriesData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $categoryNames = [
            'smartphones',
            'laptops',
            'monitors',
            'tablets',
            'desktops',
            'ebooks',
            'graphic-cards',
            'routers',
        ];
        $categories = [];

        foreach ($categoryNames as $categoryName) {
            $category = new Category();
            $category->setName($categoryName);
            $categories[] = $category;
        }

        array_map(function($category) use ($manager) {
            $manager->persist($category);
            $manager->flush();
        }, $categories);
    }

    public function getOrder(): int
    {
        return 10;
    }
}
