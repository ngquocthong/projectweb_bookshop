<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\OrderRepository;
use App\Entity\Order;

class ApiOrderController extends AbstractController
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

    #[Route('/api/order/show', name: 'app_api_order', methods: ['GET'])]
    public function index(OrderRepository $orderRepository): Response
    {
        $order = $orderRepository->findAll();
        $data = [];

        foreach ($order as $or){
            $data[] = [
                'id' => $or->getId(), 
                'date'   => $or->getDate(),
                'phone' => $or->getPhone(),
                'fullname' => $or->getFullname(),
                'address' => $or->getAddress(),
                'deliverydate' => $or->getDeliverydate()
            ];
        }
        return $this->json($data);
    }
    #[Route('/api/order/show/{id}', name: 'app_api_order_show', methods: ['GET'])]
    public function show(Request $request,OrderRepository $orderRepository): Response
    {
        $orders = $orderRepository->findOneBy(['id' => $request->get('id')]); 
        return $this->json($orders);
    }

    
    #[Route('/api/order/new', name: 'app_api_order_new', methods: ['POST'])]
    public function new(Request $request, OrderRepository $orderRepository): Response
    {
        $order = new Order();
        $request = $this->transformJsonBody($request);
        $order->setDate($request->get('date'));
        $order->setPhone($request->get('phone'));
        $order->setFullname($request->get('fullname'));
        $order->setAddress($request->get('address'));
        $order->setDeliverydate($request->get('deliverydate'));

        $orderRepository->add($order, true);

        return $this->json("Insert OK");
    }

    #[Route('/api/order/edit/{id}', name: 'app_api_order_edit', methods: ['PUT'])]
    public function edit(Request $request, OrderRepository $orderRepository): Response
    {
        $order = $orderRepository->findOneBy(['id' => $request->get('id')]);

        $order->setDate($request->get('date'));
        $order->setPhone($request->get('phone'));
        $order->setFullname($request->get('fullname'));
        $order->setAddress($request->get('address'));
        $order->setDeliverydate($request->get('deliverydate'));
 
        $orderRepository->add($order, true);

        return $this->json("Insert OK");
    }

    #[Route('/api/order/delete/{id}', name: 'app_api_order_edit', methods: ['Delete'])]
    public function delete(Request $request, OrderRepository $orderRepository): Response
    {
        $order = $orderRepository->findOneBy(['id' => $request->get('id')]); 
        $orderRepository->remove($order, true);

        return $this->json("Delete OK");
    }
}
