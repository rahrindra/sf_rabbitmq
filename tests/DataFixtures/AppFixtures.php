<?php

namespace App\Tests\DataFixtures;

use App\Domain\Model\Category;
use App\Domain\Model\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $category = new Category();
        $category->setName('Category 1');
        $category->setReference('CAT0001');
        $manager->persist($category);

        // create 20 products! Bam!
        for ($i = 0; $i < 20; $i++) {
            $product = new Product();
            $product->setName('product '.$i);
            $product->setPrice(mt_rand(10, 100));
            $product->setQuantity(mt_rand(1, 10));
            $product->setCategory($category);
            $manager->persist($product);
        }

        $manager->flush();
    }
}
