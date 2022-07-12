<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Reader;
use App\Repository\ReaderRepository;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Form\ReaderType;


class RegistrationController extends AbstractController
{
    private $passwordEncoder;

    public function __construct(UserPasswordHasherInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    #[Route('/registration', name:'registration')]
    public function index(Request $request, UserPasswordHasherInterface $passwordEncoder, ReaderRepository $userRepo): Response
    {
        $user = new Reader();

        $form = $this->createForm(ReaderType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Encode the new users password
            $user->setPassword($passwordEncoder->hashPassword($user, $user->getPassword()));

            // Set their role
            //$user->setRoles(['ROLE_USER']);

            // Save
            $userRepo->add($user, true);

            return $this->redirectToRoute('app_homepage');
        }

        return $this->render('registration/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
