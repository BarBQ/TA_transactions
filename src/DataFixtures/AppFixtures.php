<?php

declare(strict_types = 1);

namespace App\DataFixtures;

use App\Entity\Balance;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

/**
 * Class AppFixtures
 * @package App\DataFixtures
 */
class AppFixtures extends Fixture
{
    /**
     * @param ObjectManager $manager
     */
    final public function load(ObjectManager $manager): void
    {
        $faker    = Factory::create();
        
        for ($i = 0; $i < 2; $i++) {
            $userName = sprintf("%s %s", $faker->firstName, $faker->lastName);
            
            $user = new User();
            $user->setName($userName);
            $manager->persist($user);
            
            $balance = new Balance();
            $balance->setUser($user);
            /*
             * Храним сумму в копейках, чтобы избежать неточных
             * вычислений с плавающими числами
             */
            $balance->setAmount(rand(2000, 9000) * 100);
            $balance->setCurrency('RUB');
            $manager->persist($balance);
        }
        
        $manager->flush();
    }
}
