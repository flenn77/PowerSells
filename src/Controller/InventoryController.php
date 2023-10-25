<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InventoryController extends AbstractController
{
    #[Route('/inventory', name: 'app_inventory')]
    public function index(): Response
    {
        return $this->render('inventory/index.html.twig', [
            'controller_name' => 'InventoryController',
        ]);
    }

    #[Route('/inventory/form', name: 'app_inventory_form')]
    public function form(): Response
    {
        return $this->render('inventory/formInventory.html.twig', [
            'controller_name' => 'InventoryController',
        ]);
    }
}
