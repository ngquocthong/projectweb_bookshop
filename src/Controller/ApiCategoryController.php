<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CategoryRepository;
use App\Entity\Category;
use Symfony\Component\VarDumper\Cloner\Data;
use Symfony\Component\HttpFoundation\JsonResponse;

class ApiCategoryController extends AbstractController
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

    #[Route('/api/category', name: 'app_api_category', methods: ['GET'])]
    public function index(CategoryRepository $categoryRepository): Response
    {
        $cates = $categoryRepository->findAll();
        $data = [];

        foreach ($cates as $ct){
            $data[] = [
                'id'   => $ct->getId(),
                'name' => $ct->getName(),
                'description' => $ct->getDescription()
            ];
        }

        return $this->json($data);
    }

    #[Route('/api/category/{id}', name: 'app_api_category_show', methods: ['GET'])]
    public function show(Request $request,CategoryRepository $categoryRepository): Response
    {
        $cates = $categoryRepository->findOneBy(['id' => $request->get('id')]); 
        return $this->json($cates);
    }

    #[Route('/api/category/new', name: 'app_api_category_new', methods: ['POST'])]
    public function new(Request $request, CategoryRepository $categoryRepository): Response
    {
        $category = new Category();
        $request = $this->transformJsonBody($request);
        $category->setName($request->get('name'));
        $category->setDescription($request->get('description'));
 
        $categoryRepository->add($category, true);

        return $this->json("Insert OK");
    }

    #[Route('/api/category/update/{id}', name: 'app_api_category_edit', methods: ['patch'])]
    public function update(Request $request, CategoryRepository $categoryRepository): Response
    {
        $category = $categoryRepository->findOneBy(['id' => $request->get('id')]);

        $category->setName($request->get('name'));
        $category->setDescription($request->get('description'));
 
        $categoryRepository->add($category, true);

        return $this->json("Insert OK");
    }

    #[Route('/api/category/delete/{id}', name: 'app_api_category_edit', methods: ['Delete'])]
    public function delete(Request $request, CategoryRepository $categoryRepository): Response
    {
        $category = $categoryRepository->findOneBy(['id' => $request->get('id')]); 
        $categoryRepository->remove($category, true);

        return $this->json("Delete OK");
    }

}
