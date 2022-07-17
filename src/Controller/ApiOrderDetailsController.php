<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\OrderRepository;
use App\Entity\Orderdetails;
use App\Repository\OrderdetailsRepository;

class ApiOrderDetailsController extends AbstractController
{
    protected function transformJsonBody(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        if ($data === null) {
            return $request;
        }
        $request->request->replace($data);
        return $request;
    }

    #[Route('/api/orderdetails', name: 'app_api_orderdetails', methods: ['GET'])]
    public function index(OrderdetailsRepository $orderdetailsRepository): Response
    {
        $orderdetails = $orderdetailsRepository->findAll();
        $data = [];

        foreach ($orderdetails as $ordt){
            $data[] = [
                'id' => $ordt->getId(),
                'book_id' => $ordt->getBook(),
                'order_id' => $ordt->getOrders(),
                'quantity' => $ordt->getQuantity(),
                'total' => $ordt->getTotal(),
                
            ];
        }
        return $this->json($data);
    }

    #[Route('/api/orderdetails/show/{id}', name: 'app_api_orderdetails_show', methods: ['GET'])]
    public function show(Request $request,OrderdetailsRepository $orderdetailsRepository): Response
    {
        $ordersdetails = $orderdetailsRepository->findOneBy(['id' => $request->get('id')]); 
        return $this->json($ordersdetails);
    }

    
    #[Route('/api/orderdetails/new', name: 'app_api_orderdetails_new', methods: ['POST'])]
    public function new(Request $request, OrderdetailsRepository $orderdetailsRepository): Response
    {
        $order = new Orderdetails();
        $request = $this->transformJsonBody($request);

        $order->setQuantity($request->get('quantity'));
        $order->setTotal($request->get('total'));

        $orderdetailsRepository->add($order, true);

        return $this->json("Insert OK");
    }

    #[Route('/api/orderdetails/edit/{id}', name: 'app_api_orderdetails_edit', methods: ['PUT'])]
    public function edit(Request $request, OrderdetailsRepository $orderdetailsRepository): Response
    {
        $order = $orderdetailsRepository->findOneBy(['id' => $request->get('id')]);

        $order->setQuantity($request->get('quantity'));
        $order->setTotal($request->get('total'));

 
        $orderdetailsRepository->add($order, true);

        return $this->json("Insert OK");
    }

    #[Route('/api/orderdetails/delete/{id}', name: 'app_api_orderdetails_edit', methods: ['Delete'])]
    public function delete(Request $request, OrderdetailsRepository $orderdetailsRepository): Response
    {
        $orderdetails = $orderdetailsRepository->findOneBy(['id' => $request->get('id')]); 
        $orderdetailsRepository->remove($orderdetails, true);

        return $this->json("Delete OK");
    }
}
