<?php

namespace BackEndBundle\DataFixtures\ORM;

use BackEndBundle\Entity\Category;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadCategoriesData extends AbstractFixture implements OrderedFixtureInterface
{
    const CATEGORIES_COUNT = 5;
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $categories = [];
        for ($i = 0; $i < self::CATEGORIES_COUNT; $i++) {
            $category = new Category();
            $category->setName('Category ' . $i);
            $categories[] = $category;
            $this->addReference('category' . $i, $category);
        }

        array_map(function($category) use ($manager) {
            $manager->persist($category);
            $manager->flush();
        }, $categories);
    }

    public function getOrder()
    {
        return 10;
    }
}
