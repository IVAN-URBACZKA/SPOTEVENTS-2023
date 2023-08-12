<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Article;
use Faker\Factory;



class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();


        for ($i = 0; $i < 10; $i++) {
            $article = new Article();
            $article->setTitle($faker->sentence(4));
            $article->setDescription($faker->paragraph(3));
            $article->setAuthor($faker->firstNameMale());
            $article->setDate($faker->dateTime());
            $manager->persist($article);
        }



        $manager->persist($article);

        $manager->flush();
    }
}
