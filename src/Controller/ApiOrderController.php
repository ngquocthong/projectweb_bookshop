<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiOrderController extends AbstractController
{
    #[Route('/api/order', name: 'app_api_order')]
    public function index(): Response
    {
        return $this->render('api_order/index.html.twig', [
            'controller_name' => 'ApiOrderController',
        ]);
    }
}
