<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    #[Route('/{slug}', name: 'product_category')]
    public function category($slug, CategoryRepository $catRepo): Response
    {
        $category = $catRepo->findOneBy(['slug' => $slug]);

        /* dd($category); */

        // Si la catégorie n'est pas trouvée, on lance une exception
        if (!$category) {
            /* throw new NotFoundHttpException(
                "La catégorie demandée n'existe pas."
            ); */
            throw $this->createNotFoundException("La catégorie demandée n'existe pas.");
        }

        return $this->render('product/category.html.twig', compact('slug', 'category'));
    }

    #[Route('/{category_slug}/{slug}', name: 'product_showproduct')]
    public function showProduct($slug, ProductRepository $prodRepo)
    {
        $product = $prodRepo->findOneBy([
            'slug' => $slug
        ]);

        // Si le produit n'est pas trouvé, on lance une exception
        if (!$product) {
            /* throw new NotFoundHttpException(
                "La catégorie demandée n'existe pas."
            ); */
            throw $this->createNotFoundException("Le produit demandée n'existe pas.");
        }

        return $this->render('product/showproduct.html.twig', compact('product'));
    }
}
