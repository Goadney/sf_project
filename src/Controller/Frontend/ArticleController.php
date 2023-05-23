<?php

namespace App\Controller\Frontend;

use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
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
}
