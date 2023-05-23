<?php

namespace App\Controller\Frontend;

use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController
{
    public function __construct(
        private readonly ArticleRepository $repo
    ) {
    }
    #[Route('/', name: 'homepage', methods: ['GET'])]
    public function index(): Response
    {


        return $this->render('main/index.html.twig', [
            'datas' => ['test' => 'test']

        ]);
    }
}
