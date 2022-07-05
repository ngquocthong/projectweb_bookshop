<?php

namespace App\Controller;

use App\Entity\Orderdetails;
use App\Form\OrderdetailsType;
use App\Repository\OrderdetailsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/orderdetails')]
class OrderdetailsController extends AbstractController
{
    #[Route('/', name: 'app_orderdetails_index', methods: ['GET'])]
    public function index(OrderdetailsRepository $orderdetailsRepository): Response
    {
        return $this->render('orderdetails/index.html.twig', [
            'orderdetails' => $orderdetailsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_orderdetails_new', methods: ['GET', 'POST'])]
    public function new(Request $request, OrderdetailsRepository $orderdetailsRepository): Response
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
    public function indexbyid(int $id, OrderdetailsRepository $ordeRepo): Response
    {
        $listDetail = array();;

        
        foreach ($ordeRepo->findAll() as $sizedet){
            dd($sizedet);
            if($sizedet->getBook()->getId() == 1){
                $listDetail[] = $sizedet;
                
            }
        }
        
        return $this->renderForm('orderdetails/show.html.twig', [
            'orderdetails' => $listDetail,
        ]); 
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
