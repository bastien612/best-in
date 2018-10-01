<?php

namespace App\Controller;

use App\Entity\Product;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductController extends AbstractController
{
    /**
     * @Route("/product", name="product")
     */
    public function index()
    {
        $entityManager = $this->getDoctrine()->getManager();

        $product = new Product();
        $product->setName("Poulet");
        $product->setPrice(10);

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($product);

        //Actually execute query
        $entityManager->flush();
        
        return new Response("Saved new product with id: ".$product->getId());
        // return $this->render('product/index.html.twig', [
        //     'controller_name' => 'ProductController',
        // ]);
    }

    /**
     * @Route("/product/{id}", name="product_show")
     */
    public function show($id)
    {
        $product = $this->getDoctrine()
            ->getRepository(Product::class)
            ->find($id);

        if (!$product) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }

        // return new Response('Check out this great product: '.$product->getName());
        return $this->render('product/show.html.twig', ['controller_name' => "Les produits", 'product' => $product]);
        // or render a template
        // in the template, print things with {{ product.name }}
        // return $this->render('product/show.html.twig', ['product' => $product]);
    }
}
