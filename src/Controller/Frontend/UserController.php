<?php

namespace App\Controller\Frontend;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[Route('/user', name: 'app_frontend_user')]
class UserController extends AbstractController
{
    public function __construct(
        private readonly UserRepository $repo,
        private readonly UserPasswordHasherInterface $passwordHasher

    ) {
    }
    #[Route('/register', name: '_register', methods: ['GET', 'POST'])]
    public function register(Request $request): Response|RedirectResponse
    {
        $user = new User();

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword($this->passwordHasher->hashPassword($user, $form->get('password')->getData()));

            $this->repo->save($user, true);
            $this->addFlash('success', 'User created successfully');

            return $this->redirectToRoute('app_login');
        }
        return $this->render('Frontend/User/register.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('/info', name: '_info', methods: ['GET'])]
    public function info(): Response
    {
        //recuperer les infos de l'utilsiateur connecté
        $user = $this->getUser();

        return $this->render(
            'Frontend/User/info.html.twig',
            [
                'user' => $user
            ]
        );
    }
}
