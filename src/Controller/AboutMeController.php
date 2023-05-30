<?php

namespace App\Controller;

use App\Entity\AboutMe;
use App\Form\AboutMeType;
use App\Repository\AboutMeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AboutMeController extends AbstractController
{
    #[Route('/about/me', name: 'app_about_me', methods: ['GET', 'POST'])]
    public function index(AboutMeRepository $aboutMeRepository, Request $request): Response
    {
        $aboutMe = new AboutMe();
        $form = $this->createForm(AboutMeType::class, $aboutMe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $imageFile = $form->get('image')->getData();
            $description = $form->get('description')->getData();

            if ($imageFile) {
                $newFilename = uniqid() . '.' . $imageFile->guessExtension();

                $imageFile->move(
                    $this->getParameter('images_directory'),
                    $newFilename
                );
                $aboutMe->setImage($newFilename);
            };

            // Si il existe deja une image et une description on la supprime
            $exisitDataBdd = $aboutMeRepository->findAll();
            if (!empty($exisitDataBdd)) {
                foreach ($exisitDataBdd as $data) {
                    $aboutMeRepository->remove($data, true);
                }
            }

            $aboutMe->setDescription(($description));

            $aboutMeRepository->save($aboutMe, true);

            return $this->redirectToRoute('app_about_me', [], Response::HTTP_SEE_OTHER);
        };

        $aboutMe = $aboutMeRepository->findAll();

        return $this->render('admin/about-me/about-me.html.twig', [
            'form' => $form->createView(),
            'aboutMe' => $aboutMe,
        ]);
    }
}
