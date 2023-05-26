<?php

namespace App\Controller\Backend;

use App\Entity\Categorie;
use App\Form\CategorieType;
use App\Repository\CategorieRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/categorie', name: 'admin_categorie')]
class CategorieController extends AbstractController
{

    public function __construct(
        private readonly CategorieRepository $repo
    ) {
    }
    #[Route('', name: '_index', methods: ['GET'])]
    public function index(): Response
    {

        return $this->render(
            'Backend/Categorie/index.html.twig',
            [
                'categories' => $this->repo->findAll()
            ]
        );
    }

    #[Route('/create', name: '_create', methods: ['GET', 'POST'])]
    public function create(Request $request): Response|RedirectResponse
    // Response est une classe symfo http
    {
        //chaque page a sa propre request donc on peut pas mettre dans le __construct

        $categorie = new Categorie();

        $form = $this->createForm(CategorieType::class, $categorie);
        // ArticlesType::class dit qu'on utilise le namepasce de ArticleType, on pourrait remplacer par
        // App\\Form\\ArticlesType
        // puis on lui passe l'objet article, et il le mettra a jour tout seul

        $form->handleRequest($request);
        //on verifie que la reqette est envoyé, on l'attrape

        if ($form->isSubmitted() && $form->isValid()) {
            // dd($article); //dump and die pour afficher le contenu de l'objet PAS EN PROD

            $this->repo->save($categorie, true);
            //verifier si le save a fonctionner

            $this->addFlash('success', 'Categorie created successfully');

            return $this->redirectToRoute('admin_categorie_index');
        }
        return $this->render('Backend/Categorie/create.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('/update/{id}', name: '_update', methods: ['GET', 'POST'])]
    public function update(?Categorie $categorie, Request $request): Response|RedirectResponse
    {
        //param converters, on a un id dans l'url, on place une entity dans le ()
        // de update, donc il reconnait symfony reconnait, il va chercher une categorie avec l'id dans l'url
        if (!$categorie instanceof Categorie) {
            $this->addFlash('error', 'Categorie not found');
            return $this->redirectToRoute('admin_categorie_index');
        }

        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->repo->save($categorie, true);

            $this->addFlash('success', 'Categorie updated successfully');

            return $this->redirectToRoute('admin_categorie_index');
        }

        return $this->render('Backend/Categorie/update.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('/delete/{id}', name: '_delete', methods: ['DELETE', 'POST'])]
    public function remove(?Categorie $categorie, Request $request): RedirectResponse
    //?Article $article permet avec l'id dans le route de selectionner l'article avec cette id si existant "?"
    // car si il n'existe pas ce ne sera pas du type objet Article
    {
        if (!$categorie instanceof Categorie) {
            $this->addFlash('error', 'Categorie not found');
            return $this->redirectToRoute('admin_categorie_index');
        }
        if ($this->isCsrfTokenValid('delete' . $categorie->getId(), $request->request->get('token'))) {
            $this->repo->remove($categorie, true);

            $this->addFlash('success', 'Categorie deleted successfully');
            return $this->redirectToRoute('admin_categorie_index');
        }
        $this->addFlash('error', 'token invalid');
        return $this->redirectToRoute('admin_categorie_index');
    }
}
