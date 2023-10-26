<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\ProductType;
use App\Entity\Product;

class InventoryController extends AbstractController
{
    #[Route('/inventory', name: 'app_inventory')]
    /**
     * @Security("is_granted('ROLE_CAISSIER') or is_granted('ROLE_MANAGER')")
     */
    public function index(ProductRepository $productRepository): Response
    {
        $products = $productRepository->getAllActiveProducts();
        $inactiveProducts = $productRepository->getAllInactiveProducts();
        $productsAll = $this->getDoctrine()->getRepository(Product::class)->getAllProducts();


        return $this->render('inventory/index.html.twig', [
            'products' => $products,
            'inactiveProducts' => $inactiveProducts,
            
        ]);
    }

    #[Route('/inventory/form', name: 'app_inventory_form')]
    public function form(Request $request, EntityManagerInterface $entityManager): Response
    /**
     * @Security("is_granted('ROLE_CAISSIER') or is_granted('ROLE_MANAGER')")
     */
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

        return $this->render('inventory/formInventory.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    // #[Route('/inventory/delete/{id}', name: 'app_inventory_delete')]
    // /**
    //  * @Security("is_granted('ROLE_CAISSIER') or is_granted('ROLE_MANAGER')")
    //  */
    // public function deleteProduct(int $id, EntityManagerInterface $entityManager, ProductRepository $productRepository): Response
    // {
    //     $product = $productRepository->find($id);
    //     if (!$product) {
    //         $this->addFlash('error', 'Produit introuvable!');
    //         return $this->redirectToRoute('app_inventory');
    //     }
    
    //     $entityManager->remove($product);
    //     $entityManager->flush();
    
    //     $this->addFlash('success', 'Produit supprimé avec succès!');
    //     return $this->redirectToRoute('app_inventory');
    // }





    #[Route('/inventory/edit/{id}', name: 'app_inventory_edit')]
    /**
     * @Security("is_granted('ROLE_CAISSIER') or is_granted('ROLE_MANAGER')")
     */
    public function edit(int $id, Request $request, EntityManagerInterface $entityManager, ProductRepository $productRepository): Response
    {
        $product = $productRepository->find($id);
        if (!$product) {
            $this->addFlash('error', 'Produit introuvable!');
            return $this->redirectToRoute('app_inventory');
        }

        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $product->setUpdatedAt(new \DateTime());
            $entityManager->flush();
            $this->addFlash('success', 'Produit modifié avec succès!');
            return $this->redirectToRoute('app_inventory');
        }

        return $this->render('inventory/edit.html.twig', [
            'product' => $product,
            'form' => $form->createView(),
        ]);
    }


    #[Route('/inventory/deactivate/{id}', name: 'app_inventory_deactivate')]
    /**
     * @Security("is_granted('ROLE_CAISSIER') or is_granted('ROLE_MANAGER')")
     */
    public function deactivateProduct(int $id, EntityManagerInterface $entityManager, ProductRepository $productRepository): Response
    {
        $product = $productRepository->find($id);
        if (!$product) {
            $this->addFlash('error', 'Produit introuvable!');
            return $this->redirectToRoute('app_inventory');
        }
    
        $product->setActive(false);
        $entityManager->flush();
    
        $this->addFlash('success', 'Produit désactivé avec succès!');
        return $this->redirectToRoute('app_inventory');
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
