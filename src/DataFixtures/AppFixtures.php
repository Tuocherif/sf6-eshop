<?php

namespace App\DataFixtures;

use Faker\Factory;
use Faker\Provider;
use App\Entity\Product;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Création du instance de 'Faker\Generator'
        $faker = Factory::create('fr_FR');

        // Création de 100 produits
        for ($p=0; $p < 100; $p++) { 
            $product = new Product();
            $product
                /* ->setName("Produit No : $p")
                ->setPrice(mt_rand(100, 200))
                ->setSlug("produit-$p") */
                ->setName($faker->sentence())
                ->setPrice($faker->randomNumber(3))
                ->setSlug($faker->slug())
            ;

            // Préparation de la migration vers la Base de données
            $manager->persist($product);
        }

        // Envoie des 100 produits vers la Base de données
        $manager->flush();

    }
}
