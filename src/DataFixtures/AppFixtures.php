<?php

namespace App\DataFixtures;

use Bezhanov;
use Faker\Factory;
use Faker\Provider;
use App\Entity\Product;
use Liior\Faker\Prices;
use App\Entity\Category;
use Bezhanov\Faker\Provider\Commerce;
use Bluemmb\Faker\PicsumPhotosProvider;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\String\Slugger\SluggerInterface;

class AppFixtures extends Fixture
{
    public function __construct(protected SluggerInterface $slugger)
    {
    }

    public function load(ObjectManager $manager): void
    {
        // Création du instance de 'Faker\Generator'
        $faker = Factory::create('fr_FR');
        // Ajout de la librairie 'liorchamla/faker-prices'
        $faker->addProvider(new Prices($faker));
        // Ajout de la librairie 'mbezhanov/faker-provider-collection'
        $faker->addProvider(new Commerce($faker));
        // Ajout de la librairie 'bluemmb/Faker-PicsumPhotos'
        $faker->addProvider(new PicsumPhotosProvider($faker));

        // Création de 3 catégories
        for ($c=0; $c < 3; $c++) { 
            $category = new Category();
            $category
                ->setName($faker->department)
                ->setSlug(strtolower($this->slugger->slug($category->getName())))
            ;

            // symfony console 

            // Création d'un nombre aléatoire (entre 30 et 50) de produits
            for ($p=0; $p < mt_rand(30, 50); $p++) { 
                $product = new Product();
                $product
                    /* ->setName("Produit No : $p")
                    ->setPrice(mt_rand(100, 200))
                    ->setSlug("produit-$p") */
                    /* ->setName($faker->sentence()) */
                    ->setName($faker->productName)
                    ->setPrice($faker->price(4000, 20000))
                    /* ->setSlug($faker->slug()) */
                    ->setSlug(strtolower($this->slugger->slug($product->getName())))
                    ->setCategory($category)
                    ->setDescription($faker->paragraph())
                    ->setPicture($faker->imageUrl(400, 400, true))
                ;
    
                // Préparation de la migration vers la Base de données
                $manager->persist($product);
            }

            $manager->persist($category);
        }


        // Envoie des 100 produits vers la Base de données
        $manager->flush();

    }
}
