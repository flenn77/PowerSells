<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\User;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'app_dashboard')]
    /**
     * @Security("is_granted('ROLE_CAISSIER') or is_granted('ROLE_MANAGER')")
     */
    public function index(ProductRepository $productRepository): Response
    {
        $user = $this->getUser();
        $countLastProducts = $productRepository->countProductsOfLastMonth();
        $recentProducts = $productRepository->findRecentProducts();

        return $this->render('dashboard/index.html.twig', [
            'user' => $user,
            'countLastProducts' => $countLastProducts,
            'products' => $recentProducts
        ]);
    }
}
