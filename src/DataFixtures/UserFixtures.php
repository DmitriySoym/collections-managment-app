<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        $user = new User();
        $user->setUsername('admin');
        $user->setEmail('soymchenko@mail.ru');
        $user->setRoles(['ROLE_ADMIN', 'ROLE_USER']);
        $user->setPassword('$2y$13$fB.ohEL3cHCYc7dcPhQH4.i3ab8vSNrl/fx/5essSMAZLcrNCccf6');
        $user->setRegistrationDate(new \DateTime());

        $manager->persist($user);

        $manager->flush();
    }
}
