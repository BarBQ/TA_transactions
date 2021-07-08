<?php

declare(strict_types = 1);

namespace App\DataFixtures;

use App\Entity\Balance;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Money\Currency;

/**
 * Class AppFixtures
 * @package App\DataFixtures
 */
class AppFixtures extends Fixture
{
    /**
     * @param ObjectManager $manager
     */
    public final function load(ObjectManager $manager): void
    {
        $faker    = Factory::create();
        $currency = new Currency('RUB');
        
        for ($i = 0; $i < 2; $i++) {
            $userName = sprintf("%s %s", $faker->firstName, $faker->lastName);
            
            $user = new User();
            $user->setName($userName);
            $manager->persist($user);
            
            $balance = new Balance();
            $balance->setUser($user);
            $balance->setAmount(rand(2000, 9000));
            $balance->setCurrency($currency->getCode());
            $manager->persist($balance);
        }
        
        $manager->flush();
    }
}
