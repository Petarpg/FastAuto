<?php

// src/DataFixtures/ProductFixture.php
namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProductFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        
        foreach ($this->getProductData() as [$name, $price, $description, $stock]) {
            $product = new Product();
            $product->setName($name);
            $product->setPrice($price);
            $product->setDescription($description);
            $product->setStock($stock);
            $manager->persist($product);
        }

        $manager->flush();
    }

    private function getProductData(): array
    {
        return [
            ['Product 1', 10, 'Description 1', 100],
            ['Product 2', 20, 'Description 2', 200],
            ['Product 3', 30, 'Description 3', 300],
        ];
    }
}
