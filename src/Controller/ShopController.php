<?php

namespace App\Controller;

use App\Entity\Book;
use App\Entity\Feedback;
use Knp\Component\Pager\PaginatorInterface;
use App\Repository\BookRepository;
use App\Repository\CategoryRepository;
use App\Repository\FeedbackRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
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
    public function shop(CategoryRepository $repoCategory, BookRepository $repoBook, Request $request): Response
    {
        $searchString = $request->get('search');
        $categories = $repoCategory->findAll();
        $books = $repoBook->findAll();
        return $this->render('shop/book.html.twig', [
            'searchString' => $searchString,
            'categories' => $categories,
            'books' => $books,
        ]);
    }
    #[Route('/books', name: 'app_books_search',methods: ['GET'])]
    public function search(CategoryRepository $repoCategory, BookRepository $repoBook, Request $request): Response
    {   
        $searchCate= $request->get('cate');
        $searchString = $request->get('search');
        $categories = $repoCategory->findAll();
        $books = $repoBook->findAll();
        return $this->render('shop/book.html.twig', [
            'searchString' => $searchString,
            'categories' => $categories,
            'books' => $books,

        ]);
    }

    #[Route('/{id}', name: 'app_book_detail', methods: ['GET'])]
    public function show(Book $book, FeedbackRepository $feedbackRepository, Request $request): Response
    {

        $feedback = $feedbackRepository->findBy(array('book'=>$request->get('id')));
        
        return $this->render('shop/bookdetail.html.twig', [
            'book' => $book,
            'feedback' => $feedback,
        ]);
    }

    #[Route('/cate_book/{id}', name: 'app_book_cate',methods: ['GET'])]
    public function cateFilter(CategoryRepository $repoCategory,BookRepository $repoBook, Request $request): Response
    {   
        $catefilter= $request->get('id');
        $books = $repoBook->findBy(array('category'=>$catefilter));
        $searchString = $request->get('search');
        $categories = $repoCategory->findAll();
        
        return $this->render('shop/book.html.twig', [
            'books' => $books,
            'categories' => $categories,
            'searchString' => $searchString,
        ]);
    }


}