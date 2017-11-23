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

        for ($i = 0; $i < 50; $i++) {
            $address = new Address();
            $address->setLatitude($faker->randomFloat(5, 54, 56));
            $address->setLongitude($faker->randomFloat(5, 23, 27));
            $address->setAddress($faker->address);
            $address->setShopOwner($this->getReference('user' . $i));
            $address->setImageName('store.jpg');
            $address->setImageSize(2000);
            $address->setUpdatedAt($faker->dateTime());
            $manager->persist($address);
            $this->addReference('address'.$i , $address);
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