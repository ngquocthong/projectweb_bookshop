<?php

namespace App\Controller;

use App\Entity\Cart;
use App\Form\CartType;
use App\Repository\CartRepository;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\BookRepository;
use App\Controller\SecurityController;

#[Route('/cart')]
class CartController extends AbstractController
{
    private $security;

    public function __construct(SecurityController $security)
    {
        $this->security = $security;
    }

    #[Route('/', name: 'app_cart_index', methods: ['GET'])]
    public function index(CartRepository $cartRepository): Response
    {
        return $this->render('cart/index.html.twig', [
            'carts' => $cartRepository->findBy(array('user' => $this->security->getUser())),
        ]);
    }

    #[Route('/{id}', name: 'app_cart_new', methods: ['GET'])]
    public function new(Request $request, BookRepository $bookRepository, CartRepository $cartRepository): Response
    {
        $cart = new Cart();
        $cart->setBook($bookRepository->findOneBy(array('id' => $request->get('id'))));
        $cart->setUser($this->security->getUser());
        $form = $this->createForm(CartType::class, $cart);
        $form->handleRequest($request);
        $cartRepository->add($cart, true);

        return $this->redirectToRoute('app_cart_index');
    }

    #[Route('/{id}/up', name: 'app_cart_up', methods: ['GET'])]
    public function up(Request $request, Cart $cart, CartRepository $cartRepository): Response
    {
        $form = $this->createForm(CartType::class, $cart);
        $cart->setQuantity($cart->getQuantity() + 1);
        $form->handleRequest($request);
        $cartRepository->add($cart, true);
        return $this->redirectToRoute('app_cart_index', [], Response::HTTP_SEE_OTHER);
    }
    #[Route('/{id}/down', name: 'app_cart_down', methods: ['GET'])]
    public function down(Request $request, Cart $cart, CartRepository $cartRepository): Response
    {
        $form = $this->createForm(CartType::class, $cart);
        if ($cart->getQuantity() == 1) {
            $cartRepository->remove($cart, true);
        } else {
            $cart->setQuantity($cart->getQuantity() - 1);
            $form->handleRequest($request);
            $cartRepository->add($cart, true);
        }
        return $this->redirectToRoute('app_cart_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/delete', name: 'app_cart_delete', methods: ['GET'])]
    public function delete(Request $request, Cart $cart, CartRepository $cartRepository): Response
    {
        $cartRepository->remove($cart, true);
        return $this->redirectToRoute('app_cart_index', [], Response::HTTP_SEE_OTHER);
    }
}