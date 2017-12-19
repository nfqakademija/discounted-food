<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        //creates admin user
        $userManager = $this->container->get('fos_user.user_manager');

        $userAdmin = $userManager->createUser();

        $userAdmin->setUsername('admin');
        $userAdmin->setEmail('system@example.com');
        $userAdmin->setCompanyName('noreply');
        $userAdmin->setLegalEntityCode(4535345345);
        $userAdmin->setPhone('000-000-000');
        $userAdmin->setPlainPassword('realadmin');
        $userAdmin->setEnabled(true);
        $userAdmin->setRoles(array('ROLE_ADMIN'));
        $userManager->updateUser($userAdmin, true);

        //other fixture class can reach admin obj
        $this->addReference('admin-user', $userAdmin);


        //creates user for demonstration
        $simpleUser = $userManager->createUser();
        $simpleUser->setUsername('user');
        $simpleUser->setEmail('user@example.com');
        $simpleUser->setCompanyName('my company');
        $simpleUser->setLegalEntityCode(123123123);
        $simpleUser->setPhone('+37060000000');
        $simpleUser->setPlainPassword('realuser');
        $simpleUser->setEnabled(true);
        $simpleUser->setRoles(array('ROLE_USER'));
        $this->addReference('realuser', $simpleUser);
        $manager->persist($simpleUser);
        $manager->flush();


         $faker = Factory::create();

         //creates 50 users
        for ($i =0; $i < 50; $i++) {
            $user = new User();
            $user->setEmail($faker->email);
            $user->setUsername($faker->userName);
            $user->setCompanyName($faker->company);
            $user->setLegalEntityCode($faker->randomDigit);
            $user->setPhone($faker->phoneNumber);
            $user->setPlainPassword('password');
            $user->setEnabled(true);

            $manager->persist($user);
            $manager->flush();
            $this->addReference('user'.$i, $user);
        }
    }
}
