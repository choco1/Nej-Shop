<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\CategoryRepository;
use App\Repository\CommentRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     * @param ProductRepository $repository
     * @return Response
     */
    public function home(ProductRepository $repo): Response
    {
        $repo = $this->getDoctrine()->getRepository(Product::class);
        $products = $repo->filterDate();
        $favorits = $repo->filtreFavorit();
        $image = $repo->findCaroussel();
        $note = $repo->findMNonte();

        return $this->render('home/index.html.twig', [
            'products' => $products,
            'images' => $image,
            'favorits' => $favorits,
            'notes' => $note
        ]);
    }

}
