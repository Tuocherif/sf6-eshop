<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Création de 100 produits
        for ($p=0; $p < 100; $p++) { 
            $product = new Product();
            $product
                ->setName("Produit No : $p")
                ->setPrice(mt_rand(100, 200))
                ->setSlug("produit-$p")
            ;

            // Préparation de la migration vers la Base de données
            $manager->persist($product);
        }

        // Envoie des 100 produits vers la Base de données
        $manager->flush();

    }
}
