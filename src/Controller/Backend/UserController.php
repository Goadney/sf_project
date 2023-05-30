<?php

namespace App\Controller\Backend;

use App\Entity\User;
use App\Form\UserModifType;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/user', name: 'admin_user')]
class UserController extends AbstractController
{
    public function __construct(
        private readonly UserRepository $repo
    ) {
    }
    #[Route('gestion', name: '_gestion')]
    public function gestion(): Response
    {
        return $this->render('Backend/User/gestion.html.twig', [
            'users' => $this->repo->findAll(),
        ]);
    }

    #[Route('/{id}/edit', name: '_update', methods: ['GET', 'POST'])]
    public function update(?User $user, Request $request): Response | RedirectResponse
    {
        if (!$user instanceof User) {
            return $this->redirectToRoute('admin_user_gestion');
        }

        // TODO : create form user with condition and return view
        $form = $this->createForm(UserModifType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->repo->save($user, true);
            $this->addFlash('success', 'L\'utilisateur a bien ete modifie.');
            return $this->redirectToRoute('admin_user_gestion');
        }

        return $this->render('Backend/User/update.html.twig', [
            'form' => $form,
        ]);
    }
}
