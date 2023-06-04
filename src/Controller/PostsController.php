<?php

namespace App\Controller;

use App\Entity\Posts;
use App\Form\PostsType;
use App\Repository\PostsRepository;
use Cocur\Slugify\Slugify;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class PostsController extends AbstractController
{
    #[Route('/admin/posts', name: 'app_posts_index', methods: ['GET'])]
    public function index(PostsRepository $postsRepository, Request $request, PaginatorInterface $paginator): Response
    {
        $pagination = $paginator->paginate(
            $postsRepository->paginationQuery(),
            $request->query->get('page', 1),
            5
        );
        return $this->render('admin/posts/index.html.twig', [
            // trier par date
            'pagination' => $pagination
        ]);
    }
    // créer un post 
    #[Route('/admin/post/new', name: 'app_posts_new', methods: ['GET', 'POST'])]
    public function new(Request $request, PostsRepository $postsRepository, PostsRepository $post): Response
    {
        $post = new Posts();
        $form = $this->createForm(PostsType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('image')->getData();
            if ($imageFile) {
                $newFilename = uniqid() . '.' . $imageFile->guessExtension();

                $imageFile->move(
                    $this->getParameter('images_directory'),
                    $newFilename
                );
                $post->setImage($newFilename);
            }
            $slugify = new Slugify();
            $post->setSlug($slugify->slugify($post->getTitre()));
            $post->setAlt($post->getTitre());
            $postsRepository->save($post, true);

            return $this->redirectToRoute('app_posts_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('/admin/posts/new.html.twig', [
            'post' => $post,
            'form' => $form,
        ]);
    }
    //Montrer un post ADMIN
    #[Route('/admin/post/{id}', name: 'app_posts_show', methods: ['GET'])]
    public function show(Posts $post): Response
    {
        return $this->render('/admin/posts/show.html.twig', [
            'post' => $post,
        ]);
    }

    //Editer un post
    #[Route('/admin/post/edit/{id}', name: 'app_posts_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Posts $post, PostsRepository $postsRepository): Response
    {
        $form = $this->createForm(PostsType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('image')->getData();
            if ($imageFile) {
                $newFilename = uniqid() . '.' . $imageFile->guessExtension();

                $imageFile->move(
                    $this->getParameter('images_directory'),
                    $newFilename
                );
                $post->setImage($newFilename);
            }

            $slugify = new Slugify();
            $post->setSlug($slugify->slugify($post->getTitre()));
            $postsRepository->save($post, true);


            return $this->redirectToRoute('app_posts_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('/admin/posts/edit.html.twig', [
            'post' => $post,
            'form' => $form,
        ]);
    }
    //Supprimer un post
    #[Route('/admin/post/{id}', name: 'app_posts_delete', methods: ['POST'])]
    public function delete(Request $request, Posts $post, PostsRepository $postsRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $post->getId(), $request->request->get('_token'))) {
            $postsRepository->remove($post, true);
        }

        return $this->redirectToRoute('app_posts_index', [], Response::HTTP_SEE_OTHER);
    }
    #[Route('admin/posts/export', name: 'app_post_export', methods: ['GET'])]
    public function exportExcel(PostsRepository $postsRepository)
    {
        $posts = $postsRepository->findAll();

        $response = new Response();
        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment;filename="post.csv"');

        $out = fopen('php://output', 'w');
        $head = ["id", 'auteur', 'titre', 'date de publication', 'date de creation'];
        fputcsv($out, $head, ';');
        foreach ($posts as $post) {
            $userData = [
                'id' => $post->getId(),
                'auteur' => $post->getAuteur(),
                'titre' => $post->getTitre(),
                'published_at' =>$post->getPublishedAt()->format('d/m/Y'),
                'date' => $post->getDate()->format('d/m/y')
            ];
            fputcsv($out, $userData, ';');
        };
        fclose($out);
        return $response;
    }
}
