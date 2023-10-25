<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\ProductType;
use App\Entity\Product;   

class ProductController extends AbstractController
{
    #[Route('/product', name: 'app_product')]
    public function index(): Response
    {
        return $this->render('product/index.html.twig', [
            'controller_name' => 'ProductController',
        ]);
    }





    
   
    #[Route('/add-product', name: 'add_product')]
        public function addProduct(Request $request, EntityManagerInterface $entityManager): Response
        {
            $product = new Product();
            $form = $this->createForm(ProductType::class, $product);
    
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $product->setCreatedAt(new \DateTime());
                $product->setUpdatedAt(new \DateTime());
                $entityManager->persist($product);
                $entityManager->flush();
    
                $this->addFlash('success', 'Produit ajouté avec succès!');
                return $this->redirectToRoute('dashboard');
            }
    
            return $this->render('product/index.html.twig', [
                'form' => $form->createView(),
            ]);
        }
    }