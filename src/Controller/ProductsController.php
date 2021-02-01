<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Comment;
use App\Entity\Product;
use App\Form\CommentType;
use App\Repository\CategoryRepository;
use App\Repository\ColorRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductsController extends AbstractController
{


    /**
     * @param $id
     * @param Request $request
     * @param CategoryRepository $categoryRepository
     * @return Response
     * @Route("/products/category/{id}", name="single_category")
     */
    public function category($id, Request $request,CategoryRepository $categoryRepository): Response
    {
        $repo = $this->getDoctrine()->getRepository(Product::class);

        $product = $repo->findFilters($id);

        $category = $categoryRepository->findAll();
        return $this->render('products/category-product.html.twig', [
            'categorys' => $category,
            'products' => $product,

        ]);
    }




    /**
     * @Route("/products/{id}", name="single_product")
     * @param Product $product
     * @return Response
     */
    public function show( Product $product): Response
    {

        $comment = new Comment();

        $form = $this->createForm(CommentType::class, $comment);


        return $this->render('products/single-product.html.twig', [
            'product' => $product,
            'commentForm' => $form->createView()
        ]);
    }


    /**
     * @Route("/products", name="list_products")
     * @param ProductRepository $repo
     * @param CategoryRepository $categoryRepository
     * @return Response
     */
    public function list(ProductRepository $repo, CategoryRepository $categoryRepository, ColorRepository $repoColor): Response
    {
        $nameOfCalor = $repoColor->findAll();
        $category = $categoryRepository->findAll();
        $products = $repo->findAll();
        return $this->render('products/all-products.html.twig', [
            'products' => $products,
            'categorys' => $category,
            'colors'  => $nameOfCalor,
        ]);
    }



}
