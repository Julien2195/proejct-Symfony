<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\InscriptionUserType;
use App\Form\User1Type;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends  AbstractController
{

    //Afficher les profils
    #[Route('/admin/users', name: 'app_users')]
    public function users(EntityManagerInterface $em)

    {

        $users = $em->getRepository(User::class)->findAll();
        return $this->render('/admin/adminPanel.html.twig', [
            'users' => $users,
        ]);
    }

    //Supprimer un utilisateur
    #[Route('/admin/{id}', name: 'app_user_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, UserRepository $userRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->request->get('_token'))) {
            $userRepository->remove($user, true);
        }

        return $this->redirectToRoute('app_users', [], Response::HTTP_SEE_OTHER);
    }


    #[Route('/admin', name: 'app_user_index', methods: ['GET'])]
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('/admin/usersPanel.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    //Créer un utilisateur
    #[Route('/admin/new', name: 'app_user_new', methods: ['GET', 'POST'])]
    public function new(Request $request, UserRepository $userRepository): Response
    {
        $user = new User();
        $form = $this->createForm(InscriptionUserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userRepository->save($user, true);

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('/admin/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    //Editer un utilisateur
    #[Route('/admin/{id}/edit', name: 'app_user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, UserRepository $userRepository): Response
    {
        $form = $this->createForm(User1Type::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $userRepository->save($user, true);

            return $this->redirectToRoute('app_users', ['id' => $user->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('/admin/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }
}
