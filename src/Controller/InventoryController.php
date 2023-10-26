<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

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
    /**
     * @Security("is_granted('ROLE_CAISSIER') or is_granted('ROLE_MANAGER')")
     */
    public function form(): Response
    {
        return $this->render('inventory/formInventory.html.twig', [
            'controller_name' => 'InventoryController',
        ]);
    }
}
