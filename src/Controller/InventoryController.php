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
        $products = $productRepository->getAllProducts();

        return $this->render('inventory/index.html.twig', [
            'products' => $products
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
