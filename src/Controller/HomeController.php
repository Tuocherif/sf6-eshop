<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'homepage')]
    public function homepage(ProductRepository $pRepo): Response
    {
        // On récupère 3 produits depuis DB
        $products = $pRepo->findBy([], [], 3);

        /* dd($products); */

        return $this->render('home/home.html.twig', compact('products'));
    }
}
