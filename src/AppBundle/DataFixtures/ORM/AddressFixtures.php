<?php
/**
 * Created by PhpStorm.
 * User: t0000678
 * Date: 11/19/17
 * Time: 7:38 PM
 */

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Address;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class AddressFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        for ($i = 0; $i < 100; $i++) {
            $address = new Address();


            if ($i < 20) {
                //vilnius
                $address->setLatitude($faker->randomFloat(5, 54.65, 54.7));
                $address->setLongitude($faker->randomFloat(5, 25.25, 25.3));
            } elseif ($i >= 20 && $i < 40) {
                //kaunas
                $address->setLatitude($faker->randomFloat(5, 54.85, 54.95));
                $address->setLongitude($faker->randomFloat(5, 23.85, 23.95));
            } elseif ($i >= 40 && $i < 60) {
                //siauliai
                $address->setLatitude($faker->randomFloat(5, 55.9, 55.99));
                $address->setLongitude($faker->randomFloat(5, 23.25, 23.36));
            } elseif ($i >= 60 && $i < 80) {
                //klaipeda
                $address->setLatitude($faker->randomFloat(5, 55.65, 55.75));
                $address->setLongitude($faker->randomFloat(5, 21.1, 21.19));
            } elseif ($i >= 80 && $i < 100) {
                //panevezys
                $address->setLatitude($faker->randomFloat(5, 55.68, 55.78));
                $address->setLongitude($faker->randomFloat(5, 24.3, 24.4));
            }

            $address->setAddress($faker->address);
            $address->setShopOwner($this->getReference('user' . $i));
            $address->setImageName('store.jpg');
            $address->setImageSize(2000);
            $address->setUpdatedAt($faker->dateTime());
            $manager->persist($address);
            $this->addReference('address'.$i, $address);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            UserFixtures::class,
        );
    }
}
