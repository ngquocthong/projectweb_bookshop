<?php

namespace App\Controller;

use App\Entity\Orderdetails;
use App\Form\OrderdetailsType;
use App\Repository\BookRepository;
use App\Repository\OrderRepository;
use App\Repository\UserRepository;
use App\Repository\OrderdetailsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

#[Route('/orderdetails')]
class OrderdetailsController extends AbstractController
{

    #[Route('/{id}', name: 'app_orderdetails_index', methods: ['GET'])]
    #[IsGranted('ROLE_ADMIN', statusCode: 404, message: 'You have have right to access admin function.')]
    public function index(OrderdetailsRepository $orderdetailsRepository,Request $request): Response
    {
        return $this->render('orderdetails/index.html.twig', [
            'orderdetails' => $orderdetailsRepository->findBy(array('orders' => $request->get('id'))),
        ]);
    }
    #[Route('/form/{id}', name: 'app_orderdetails_form', methods: ['GET'])]
    #[IsGranted('ROLE_USER', statusCode: 404, message: 'You have have right to access admin function.')]
    public function index1(OrderdetailsRepository $orderdetailsRepository,Request $request, OrderRepository $orderRepository,UserRepository $userRepository): Response
    {
        return $this->render('orderdetails/_form.html.twig', [
            'orderdetails' => $orderdetailsRepository->findBy(array('orders' => $request->get('id'))),
        ]);
    }

    #[Route('/new', name: 'app_orderdetails_new', methods: ['GET', 'POST'])]
    public function new(Request $request, OrderdetailsRepository $orderdetailsRepository, BookRepository $bookRepository): Response
    {
        
        $orderdetail = new Orderdetails();
        $form = $this->createForm(OrderdetailsType::class, $orderdetail);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $orderdetailsRepository->add($orderdetail, true);

            return $this->redirectToRoute('app_orderdetails_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('orderdetails/new.html.twig', [
            'orderdetail' => $orderdetail,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_orderdetails_show', methods: ['GET'])]
    public function indexbyid(int $id, Request $request,OrderdetailsRepository $ordeRepo, BookRepository $bookRepository,OrderRepository $orderRepository): Response
    {
        // $listDetail = array();
        $orderdetail = new Orderdetails();
        $orderdetail->setBook($bookRepository->findOneBy(array('id' => $request->get('id'))));
        $orderdetail->setOrders($orderRepository->findOneBy(array('id' => $request->get('id'))));
        // foreach ($ordeRepo->findAll() as $sizedet){
        //     // dd($sizedet);
        //     if($sizedet->getBook()->getId() == 1){
        //         $listDetail[] = $sizedet;
                
        //     }
        // }
        return $this->redirectToRoute('app_orderdetails_form', [], Response::HTTP_SEE_OTHER);
        // return $this->renderForm('orderdetails/show.html.twig', [
        //     'orderdetails' => $listDetail,
        // ]); 
    }


    #[Route('/{id}/edit', name: 'app_orderdetails_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Orderdetails $orderdetail, OrderdetailsRepository $orderdetailsRepository): Response
    {
        $form = $this->createForm(OrderdetailsType::class, $orderdetail);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $orderdetailsRepository->add($orderdetail, true);

            return $this->redirectToRoute('app_orderdetails_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('orderdetails/edit.html.twig', [
            'orderdetail' => $orderdetail,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_orderdetails_delete', methods: ['POST'])]
    public function delete(Request $request, Orderdetails $orderdetail, OrderdetailsRepository $orderdetailsRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$orderdetail->getId(), $request->request->get('_token'))) {
            $orderdetailsRepository->remove($orderdetail, true);
        }

        return $this->redirectToRoute('app_orderdetails_index', [], Response::HTTP_SEE_OTHER);
    }
    
}
