<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin/new", name="new_product")
     * @param Request $request
     * @return Response
     */
    public function add(Request $request): Response
    {

            $product = new Product();
            $form = $this->createForm(ProductType::class, $product);
            $form->handleRequest($request);

           if($form->isSubmitted() && $form->isValid()){

               $image = $form->get('image')->getData();
               if($image){
                   $file = uniqid().'.'. $image->guessExtension();
                   $image->move($this->getParameter('upload_directory'), $file);
                   $product->setImage($file);
               }


               $entityManager = $this->getDoctrine()->getManager();
               $entityManager->persist($product);
               $entityManager->flush();

               $this->addFlash('success', 'Votre produit '.$product->getId().' a bien été ajoutée');

               return $this->redirectToRoute('single_product', ['id' => $product->getId()]);
           }

        return $this->render('admin/registration.html.twig', [
            'formProduct' => $form->createView(),
        ]);
    }


    /**
     * @Route("/admin/edit/{id}", name="edit_product")
     * @param Request $request
     * @param Product $product
     * @return Response
     */
    public function edit(Request $request, Product $product): Response
    {
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $image = $form->get('image')->getData();
            if($image == null){
                $tmpImage = 's20.jpeg';
                $image = 's20.jpeg';
                if($product->getImage() && $product->getImage() !== $tmpImage){
                    $newFile = new Filesystem();
                    $newFile->remove($this->getParameter('upload_directory').'/'.$product->getImage());
                }
                $file = uniqid().'.'. $image->guessExtension();
                $image->move($this->getParameter('upload_directory'), $file);
                $product->setImage($file);
            }

            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'Votre modification à été éffectué avec success !!!!!');

            return $this->redirectToRoute('list_products');
        }


        return $this->render('admin/edit.html.twig', [
            'product' => $product,
            'formProduct' => $form->createView(),
        ]);
    }


    /**
     * @param Product $product
     * @Route("/admin/delet/{id}", name="delete_product")
     * @return Response
     */
    public function delete(Product $product): Response {

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($product);
        $entityManager->flush();

        $this->addFlash('danger','Votre produit a été suprimé avec success !!!!');

        return $this->redirectToRoute('list_products');
    }
}
