<?php

namespace App\Controller\Backend;

use App\Entity\Article;
use App\Form\ArticlesType;
use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

#[Route('/admin/article', name: 'admin_article')]
// un attribut php 8 sur une classe fait que Avant chaque path de méthode/fonction il y aura /admin/article
// C'est enfait pour les routes qui ont le meme path au début
class ArticleController extends AbstractController
{
    public function __construct(
        private readonly ArticleRepository $repo
    ) {
    }
    //Nouvelle manière de créer les propriétés en php8
    // 
    #[Route('', name: '_index', methods: ['GET'])]
    public function index(): Response
    {

        return $this->render(
            'Backend/Article/index.html.twig',
            [
                'articles' => $this->repo->findAll()
            ]
        );
    }

    #[Route('/create', name: '_create', methods: ['GET', 'POST'])]
    public function create(Request $request): Response|RedirectResponse
    // Response est une classe symfo http
    {
        //chaque page a sa propre request donc on peut pas mettre dans le __construct

        $article = new Article();

        $form = $this->createForm(ArticlesType::class, $article);
        // ArticlesType::class dit qu'on utilise le namepasce de ArticleType, on pourrait remplacer par
        // App\\Form\\ArticlesType
        // puis on lui passe l'objet article, et il le mettra a jour tout seul

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // dd($article); //dump and die pour afficher le contenu de l'objet PAS EN PROD
            $this->repo->save($article, true);
            //verifier si le save a fonctionner

            $this->addFlash('success', 'Article created successfully');

            return $this->redirectToRoute('admin_article_index');
        }
        return $this->render('Backend/Article/create.html.twig', [
            'form' => $form
        ]);
    }


    #[Route('/update/{id}', name: '_update', methods: ['GET', 'POST'])]
    public function update(?Article $article, Request $request): Response|RedirectResponse
    {
        if (!$article instanceof Article) {
            $this->addFlash('error', 'Article not found');
            return $this->redirectToRoute('admin_article_index');
        }

        $form = $this->createForm(ArticlesType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->repo->save($article, true);

            $this->addFlash('success', 'Article updated successfully');

            return $this->redirectToRoute('admin_article_index');
        }

        return $this->render('Backend/Article/update.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('/remove/{id}', name: '_remove', methods: ['GET', 'POST'])]
    public function remove(?Article $article, Request $request): Response|RedirectResponse
    {
        if (!$article instanceof Article) {
            $this->addFlash('error', 'Article not found');
            return $this->redirectToRoute('admin_article_index');
        }

        $form = $this->createForm(ArticlesType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->repo->remove($article, true);

            $this->addFlash('success', 'Article removed successfully');

            return $this->redirectToRoute('admin_article_index');
        }

        return $this->render('Backend/Article/update.html.twig', [
            'form' => $form
        ]);
    }
}
