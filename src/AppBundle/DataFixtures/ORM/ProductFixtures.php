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

        $foodPhotos = ['burger', 'omelette', 'pancakes', 'pizza', 'quinoa', 'spaghetti', 'soup', 'cepelinai'];

        $photoIndex = 0;

        for ($i = 0; $i < 100; $i++) {
            $product = new Product();

            $product->setDescription($faker->sentence(4));
            $product->setPortions($faker->numberBetween(1, 10));
            $product->setPrice($faker->numberBetween(1, 8));
            $product->setDateFrom($faker->dateTime());
            $product->setDateTo($faker->dateTime());
            $product->setAddress($this->getReference('address' . $i));

            if ($photoIndex === 8) {
                $photoIndex = 0;
            }

            $product->setName($foodPhotos[$photoIndex]);
            $product->setImageName($foodPhotos[$photoIndex] . '.jpg');

            $photoIndex++;

            $product->setImageSize(2000);
            $product->setUpdatedAt($faker->dateTime());

            switch ($photoIndex) {
                case 1:
                    $product->setMeal(1);
                    break;
                case 2:
                    $product->setDessert(1);
                    $product->setVegan(1);
                    $product->setVegetarian(1);
                    break;
                case 3:
                    $product->setMeal(1);
                    break;
                case 4:
                    $product->setVegetarian(1);
                    $product->setDessert(1);
                    break;
                case 5:
                    $product->setMeal(1);
                    break;
                case 6:
                    $product->setVegan(1);
                    $product->setMeal(1);
                    break;
                case 7:
                    $product->setVegetarian(1);
                    $product->setMeal(1);
                    break;
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
