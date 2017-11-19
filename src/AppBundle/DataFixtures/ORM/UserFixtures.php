<?php
/**
 * Created by PhpStorm.
 * User: t0000678
 * Date: 11/19/17
 * Time: 7:47 PM
 */

namespace AppBundle\DataFixtures\ORM;


use AppBundle\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager) {

        //creates one admin user
        $userManager = $this->container->get('fos_user.user_manager');

        $userAdmin = $userManager->createUser();

        $userAdmin->setUsername('admin');
        $userAdmin->setEmail('system@example.com');
        $userAdmin->setCompanyName('noreply');
        $userAdmin->setLegalEntityCode(4535345345);
        $userAdmin->setPhone('000-000-000');
        $userAdmin->setPlainPassword('admin');
        $userAdmin->setEnabled(true);
        $userManager->updateUser($userAdmin, true);

        //other fixture class can reach admin obj
        $this->addReference('admin-user', $userAdmin);


         $faker = Factory::create();

         //creates 100 regular users
        for($i =0; $i < 10; $i++) {

            $user = new User();
            $user->setEmail($faker->email);
            $user->setUsername( $faker->userName);
            $user->setCompanyName($faker->company);
            $user->setLegalEntityCode($faker->randomDigit);
            $user->setPhone($faker->phoneNumber);
            $user->setPlainPassword('password');
            $user->setEnabled(true);

            $manager->persist($user);
            $manager->flush();
            $this->addReference('user'.$i , $user);
        }
    }
}