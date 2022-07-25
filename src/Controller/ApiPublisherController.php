<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\PublisherRepository;
use App\Entity\Publisher;
use Symfony\Component\VarDumper\Cloner\Data;
use Symfony\Component\HttpFoundation\JsonResponse;

class ApiPublisherController extends AbstractController
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

    #[Route('/api/publisher', name: 'app_api_publisher', methods: ['GET'])]
    public function index(PublisherRepository $publisherRepository): Response
    {
        $cates = $publisherRepository->findAll();
        $data = [];

        foreach ($cates as $ct){
            $data[] = [
                'id'   => $ct->getId(),
                'name' => $ct->getName(),
            ];
        }
        return $this->json($data);
    }

    #[Route('/api/publisher/{id}', name: 'app_api_publisher_show', methods: ['GET'])]
    public function show(Request $request,PublisherRepository $publisherRepository): Response
    {
        $cates = $publisherRepository->findOneBy(['id' => $request->get('id')]); 
        return $this->json($cates);
    }

    #[Route('/api/publisher/new', name: 'app_api_publisher_new', methods: ['POST'])]
    public function new(Request $request, PublisherRepository $publisherRepository): Response
    {
        $publisher = new Publisher();
        $request = $this->transformJsonBody($request);
        $publisher->setName($request->get('name'));
 
        $publisherRepository->add($publisher, true);

        return $this->json("Insert OK");
    }

    #[Route('/api/publisher/update/{id}', name: 'app_api_publisher_edit', methods: ['PUT'])]
    public function update(Request $request, PublisherRepository $publisherRepository): Response
    {
        $publisher = $publisherRepository->findOneBy(['id' => $request->get('id')]);

        $publisher->setName($request->get('name'));
 
        $publisherRepository->add($publisher, true);

        return $this->json("Insert OK");
    }

    #[Route('/api/publisher/delete/{id}', name: 'app_api_publisher_edit', methods: ['Delete'])]
    public function delete(Request $request, PublisherRepository $publisherRepository): Response
    {
        $publisher = $publisherRepository->findOneBy(['id' => $request->get('id')]); 
        $publisherRepository->remove($publisher, true);

        return $this->json("Delete OK");
    }

}
