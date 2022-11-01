<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class ProductController extends AbstractController
{
    // Action permettant d'afficher une "Category"
    #[Route('/{slug}', name: 'product_showcategory')]
    public function showCategory($slug, CategoryRepository $catRepo): Response
    {
        $category = $catRepo->findOneBy(['slug' => $slug]);

        /* dd($category); */

        // Si la catégorie n'est pas trouvée, on lance une exception
        if (!$category) {
            /* throw new NotFoundHttpException(
                "La catégorie demandée n'existe pas."
            ); */
            throw $this->createNotFoundException(
                "La catégorie demandée n'existe pas."
            );
        }

        return $this->render(
            'product/showcategory.html.twig',
            compact('slug', 'category')
        );
    }

    // Action permettant d'afficher un "Product"
    #[Route('/{category_slug}/{slug}', name: 'product_showproduct')]
    public function showProduct(
        $slug, 
        ProductRepository $prodRepo,
        UrlGeneratorInterface $urlGenerator
    )
    {
        /* dd($urlGenerator->generate('product_category', [
            'slug' => $slug
        ])); */

        $product = $prodRepo->findOneBy([
            'slug' => $slug,
        ]);

        // Si le produit n'est pas trouvé, on lance une exception
        if (!$product) {
            /* throw new NotFoundHttpException(
                "La catégorie demandée n'existe pas."
            ); */
            throw $this->createNotFoundException(
                "Le produit demandée n'existe pas."
            );
        }

        return $this->render(
            'product/showproduct.html.twig',
            compact('product', 'urlGenerator')
        );
    }
}
