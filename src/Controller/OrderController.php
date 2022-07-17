<?php

namespace App\Controller;

use App\Entity\Order;
use App\Form\OrderType;
use App\Repository\CartRepository;
use App\Repository\UserRepository;
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

    #[Route('/new', name: 'app_order_new', methods: ['GET', 'POST'])]
    public function new(Request $request, OrderRepository $orderRepository,UserRepository $userRepository, OrderdetailsRepository $orderDetailRepository, CartRepository $cartRepository): Response
    {
        $order = new Order(); 
        $order->setUser($this->security->getUser());
        $form = $this->createForm(OrderType::class, $order);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $orderRepository->add($order, true);
            
            $carts = $cartRepository->findBy(array('user' => $this->security->getUser()));
            // $order->setUser($userRepository->findOneBy(array('id' => $request->get('id'))));
            foreach($carts as $cart) {
                $orderDetail = new Orderdetails();
                $orderDetail->setBook($cart->getBook());
                $orderDetail->setOrders($order);
                $orderDetail->setQuantity($cart->getQuantity());
                $orderDetailRepository->add($orderDetail,true);
                $cartRepository->remove($cart,true);
            }
            return $this->redirectToRoute('app_orderdetails_form', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('order/new.html.twig', [
            'order' => $order,
            'form' => $form,
        ]);
    } 
}
