<?php

namespace App\Controller;

use App\Entity\Order;
use App\Form\OrderType;
use App\Repository\CartRepository;
use App\Repository\BookRepository;
use App\Repository\OrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Orderdetails;
use App\Repository\OrderdetailsRepository;

use function Symfony\Component\String\s;

#[Route('/order')]
class OrderController extends AbstractController
{
    private $security;

    public function __construct(SecurityController $security)
    {
        $this->security = $security;
    } 

    #[Route('/', name: 'app_order_index', methods: ['GET'])]

    public function index(OrderRepository $orderRepository): Response
    {
        return $this->render('order/index.html.twig', [
            'orders' => $orderRepository->findBy(array('user' => $this->security->getUser())),
        ]);
    }

    #[Route('/show', name: 'app_order_indexshow', methods: ['GET'])]
    public function index1(OrderRepository $orderRepository): Response
    {
        return $this->render('order/show.html.twig', [
            'orders' => $orderRepository->findBy(array('user' => $this->security->getUser())),
        ]);
    }


    #[Route('/new', name: 'app_order_new', methods: ['GET', 'POST'])]
    public function new(Request $request, OrderRepository $orderRepository, CartRepository $cartRepository, OrderdetailsRepository $orderdetailsRepository): Response
    {
        $order = new Order();
        $order->setUser($this->security->getUser());
        $cart = $cartRepository->findBy(array('user' => $this->security->getUser()));
        $total = 0;   
       
        foreach ($cart as $oneCart) {
           
           $total += ($oneCart->getBook()->getPrice() * $oneCart->getQuantity());
        }

        $order->setTotal($total);
        $form = $this->createForm(OrderType::class, $order);
        $form->handleRequest($request);
        

        if ($form->isSubmitted() && $form->isValid()) {
            $orderRepository->add($order, true);
            foreach ($cart as $oneCart) {
                $orderdetails = new Orderdetails();
                $orderdetails->setBook($oneCart->getBook());
                $orderdetails->setOrders($order);
                $orderdetails->setQuantity($oneCart->getQuantity());
                $orderdetails->setTotal($oneCart->getBook()->getPrice() * $oneCart->getQuantity());
                $orderdetailsRepository->add($orderdetails, true);
                $cartRepository->remove($oneCart, true);
            }
            return $this->redirectToRoute('app_order_indexshow', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('order/new.html.twig', [
            'order' => $order,
            'form' => $form,
        ]);
    } 
    #[Route('/{id}/edit', name: 'app_order_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Order $order, OrderRepository $orderRepository): Response
    {
        $form = $this->createForm(OrderType::class, $order);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $orderRepository->add($order, true);

            return $this->redirectToRoute('app_order_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('order/edit.html.twig', [
            'order' => $order,
            'form' => $form,
        ]);
    }
}
