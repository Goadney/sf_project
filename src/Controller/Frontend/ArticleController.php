<?php

namespace App\Controller\Frontend;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/article', name: 'app_frontend_article')]
class ArticleController extends AbstractController
{  public function __construct(
    private readonly ArticleRepository $repo
) {
}
    #[Route('/liste', name: '_index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('Frontend/Article/index.html.twig', [
            'articles' => $this->repo->findAllWithTags(true)]);


    }

    #[Route('/{slug}', name: '_show', methods: ['GET'])]
    public function showArticle(?Article $article ): Response|RedirectResponse
    {
        if (!$article instanceof Article || !$article->isActif()) {
            $this->addFlash('error', 'Article not found');
            return $this->redirectToRoute('app_frontend_article_index');
        }
        
        return $this->render('Frontend/Article/showArticle.html.twig', [
            'article' => $article]);


    }
}
