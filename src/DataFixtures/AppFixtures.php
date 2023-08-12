<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Event;
use Faker\Factory;


class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
       
        $faker = Factory::create();

        for ($i = 0; $i < 10; $i++) {
            $event = new Event();
            $event->setTitle($faker->sentence(4));
            $event->setDescription($faker->paragraph(3));
            $event->setOrganizer($faker->name());
            $event->setDate($faker->dateTime());
            $event->setCity($faker->city());
            $event->setPhoto("https://www.visit.alsace/wp-content/uploads/2018/11/festival-decibulles-2017-laurent-khram-longvixay-1-1600x900.jpg");
            $manager->persist($event);
        }


        $manager->flush();
    }
}
