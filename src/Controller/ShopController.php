<?php

namespace App\Controller;

use App\Entity\Book;
use App\Repository\BookRepository;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/shop')]
class ShopController extends AbstractController
{
    #[Route('/homepage', name: 'app_homepage')]
    public function index(): Response
    {
        return $this->render('shop/index.html.twig', [
            'controller_name' => 'ShopController',
        ]);
    }
    #[Route('/books', name: 'app_books')]
    public function shop(CategoryRepository $repoCategory, BookRepository $repoBook): Response
    {
        $categories = $repoCategory->findAll();
        $books = $repoBook->findAll();
        return $this->render('shop/book.html.twig', [
            'categories' => $categories,
            'books' => $books,
        ]);
    }
    #[Route('/{id}', name: 'app_book_detail', methods: ['GET'])]
    public function show(Book $book): Response
    {
        return $this->render('shop/bookdetail.html.twig', [
            'book' => $book,
        ]);
    }
}