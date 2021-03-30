<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Comment;
use App\Entity\Product;
use App\Entity\User;
use App\Form\CommentType;
use App\Repository\CategoryRepository;
use App\Repository\ColorRepository;
use App\Repository\ProductRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

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
     * @ParamConverter("user", options={"mapping": {"username": "username"}})
     * @param $id
     * @param Product $product
     * @param Request $request
     * @param User $user
     * @return Response
     */
    public function show($id, Product $product, Request $request, UserRepository $userRepo): Response
    {

        $repo = $this->getDoctrine()->getRepository(Product::class);

        $user = $this->getUser();
        dump($user);
       // $name = $user->getUsername();
   //dump($name);
        $productColors = $repo->selectColorsProduct();

        $noteProducts = $repo->noteProduct($id);

        $session = $request->getSession();
        //dump($session);
        $comment = new Comment();

        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);


        //dump($comment);
        if($form->isSubmitted() && $form->isValid()) {

            $comment->setProduct($product);




            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($comment);
            $entityManager->flush();

        }

        if(isset($noteProducts[0])){
            $notesProduct = $noteProducts[0][1];
        }else {
            $notesProduct = 0;
        }

        return $this->render('products/single-product.html.twig', [
            'product' => $product,
            'productColors' => $productColors,
            'noteProducts' => intval($notesProduct),
            'commentForm' => $form->createView()
        ]);
    }


    /**
     * @Route("/products", name="list_products")
     * @param ProductRepository $repo
     * @param CategoryRepository $categoryRepository
     * @return Response
     */
    public function list(Request $request, ProductRepository $repo, CategoryRepository $categoryRepository, ColorRepository $repoColor): Response
    {
        $repo = $this->getDoctrine()->getRepository(Product::class);

        $products = $repo->findByColors(
            $request->get('color')
        );

        $lastProduct = $repo->dateLastProduct();
        $nameOfCalor = $repoColor->findAll();
        $category = $categoryRepository->findAll();

        return $this->render('products/all-products.html.twig', [
            'products' => $products,
            'categorys' => $category,
            'colors'  => $nameOfCalor,
            'lastProducts' => $lastProduct
        ]);
    }




}
