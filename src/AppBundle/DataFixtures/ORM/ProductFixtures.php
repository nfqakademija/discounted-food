<?php
/**
 * Created by PhpStorm.
 * User: t0000678
 * Date: 11/19/17
 * Time: 9:22 PM
 */

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        for ($i = 0; $i < 30; $i++) {
            $product = new Product();
            $product->setName('food-name-here');
            $product->setDescription($faker->sentence(4));
            $product->setPortions($faker->numberBetween(1, 15));
            $product->setPrice($faker->numberBetween(1, 8));
            $product->setDateFrom($faker->dateTime());
            $product->setDateTo($faker->dateTime());
            $product->setAddress($this->getReference('address' . $i));
            $product->setImageName('food.jpg');
            $product->setImageSize(2000);
            $product->setUpdatedAt($faker->dateTime());

            if ($i % 2 === 0) {
                $product->setVegetarian(1);
                $product->setMeal(1);
            } else {
                $product->setDessert(1);
                $product->setVegan(1);
            }

            $manager->persist($product);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            UserFixtures::class,
            AddressFixtures::class,
        );
    }
}
