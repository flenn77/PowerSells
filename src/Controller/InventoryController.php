<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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
            $product->setActive(true);
            $entityManager->persist($product);
            $entityManager->flush();

            return $this->redirectToRoute('app_inventory');
        }

        return $this->render('inventory/formInventory.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/increment-stock', name: 'increment_stock', methods: ['POST'])]
    public function incrementStock(Request $request, ProductRepository $productRepository,
                                   EntityManagerInterface $entityManager): JsonResponse
    {
        $productId = $request->request->get('productId');
        $incrementValue = $request->request->get('incrementValue');

        $product = $productRepository->find($productId);
        if (!$product) {
            return new JsonResponse(['status' => 'error', 'message' => 'Product not found']);
        }

        $currentStock = $product->getStock();
        $product->setStock($currentStock + $incrementValue);

        $entityManager->persist($product);
        $entityManager->flush();

        return new JsonResponse(['status' => 'success', 'message' => 'Stock updated successfully']);
    }

    #[Route('/decrement-stock', name: 'decrement_stock', methods: ['POST'])]
    public function decrementStock(Request $request, ProductRepository $productRepository,
                                   EntityManagerInterface $entityManager): JsonResponse
    {
        $productId = $request->request->get('productId');
        $decrementValue = $request->request->get('decrementValue');

        $product = $productRepository->find($productId);
        if (!$product) {
            return new JsonResponse(['status' => 'error', 'message' => 'Product not found']);
        }

        $currentStock = $product->getStock();
        $product->setStock($currentStock - $decrementValue);


        $entityManager->persist($product);
        $entityManager->flush();

        return new JsonResponse(['status' => 'success', 'message' => 'Stock updated successfully']);
    }

}
