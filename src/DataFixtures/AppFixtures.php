<?php

namespace App\DataFixtures;

use Faker\Factory;
use Faker\Provider;
use App\Entity\Product;
use Liior\Faker\Prices;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Création du instance de 'Faker\Generator'
        $faker = Factory::create('fr_FR');
        // Ajout de la librairie 'liorchamla/faker-prices'
        $faker->addProvider(new Prices($faker));

        // symfony console 

        // Création de 100 produits
        for ($p=0; $p < 100; $p++) { 
            $product = new Product();
            $product
                /* ->setName("Produit No : $p")
                ->setPrice(mt_rand(100, 200))
                ->setSlug("produit-$p") */
                ->setName($faker->sentence())
                ->setPrice($faker->price(4000, 20000))
                ->setSlug($faker->slug())
            ;

            // Préparation de la migration vers la Base de données
            $manager->persist($product);
        }

        // Envoie des 100 produits vers la Base de données
        $manager->flush();

    }
}
