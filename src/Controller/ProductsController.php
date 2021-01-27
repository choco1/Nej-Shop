<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductsController extends AbstractController
{
    /**
     * @Route("/products", name="list_products")
     */
    public function list(): Response
    {
        return $this->render('products/all-products.html.twig', [
            'controller_name' => 'ProductController',
        ]);
    }


    /**
     * @Route("/products/show", name="single_product")
     */
    public function show() {

        return $this->render('products/single-product.html.twig');
    }
}
