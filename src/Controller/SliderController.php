<?php

namespace App\Controller;

use App\Entity\Slider;
use App\Form\SliderType;
use App\Repository\SliderRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\EventListener\ResponseListener;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class SliderController extends AbstractController
{
    //Création d'un nouveau slider
    #[Route('admin/API/slider/new', name: 'app_slider_new', methods: ['GET', 'POST'])]
    public function slider(Request $request, SliderRepository $sliderRepository, SerializerInterface $serialiser): Response
    {
        $slider = new Slider();
        $form = $this->createForm(SliderType::class, $slider);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('image')->getData();

            if ($imageFile) {
                $newFilename = uniqid() . '.' . $imageFile->guessExtension();

                $imageFile->move(
                    $this->getParameter('images_directory'),
                    $newFilename
                );
                $slider->setImage($newFilename);

                $slider->setAlt($slider->getTitre());
            }
            $sliderRepository->save($slider, true);

            return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render(
            '/admin/slider/slider-new.html.twig',
            [
                'form' => $form->createView()
            ]
        );
    }

    //Affichage des sliders
    #[Route('admin/API/slider/index', name: 'app_slider_index')]
    public function index(SliderRepository $sliderRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $slider = $paginator->paginate(
            $sliderRepository->paginatorQuery(),
            $request->get('page', 1),
            5
        );
        return $this->render('admin/slider/slider-index.html.twig', [
            'sliders' => $slider
        ]);
    }
    //Voir la banniere
    #[Route('admin/API/slider/{id}', name: 'app_slider_show')]
    public function show(Slider $slider)
    {

        return $this->render('admin/slider/slider-show.html.twig', [
            'slider' => $slider
        ]);
    }
    // Modifier la banniere
    #[Route('admin/api/slider/edit/{id}', name: 'app_slider_edit', methods: ['GET', 'POST'])]
    public function edit(Slider $slider, Request $request, SliderRepository $sliderRepository): Response
    {
        $form = $this->createForm(SliderType::class, $slider);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('image')->getData();
            if ($imageFile) {
                $newfileImg = uniqid() . '.' . $imageFile->guessExtension();
                $imageFile->move(
                    $this->getParameter('images_directory'),
                    $imageFile
                );
                $slider->setImage($newfileImg);
            }
            return $this->redirectToRoute('app_slider_index', [], Response::HTTP_SEE_OTHER);
        }
        $sliderRepository->save($slider, true);
        return $this->renderForm('admin/slider/slider-edit.html.twig', [
            'slider' => $slider,
            'form' => $form
        ]);
    }
    //Supprimer la banniere
    #[Route('admin/API/slider/delete/{id}', name: 'app_slider_delete', methods: ['POST'])]
    public function delete(Request $request, Slider $slider, SliderRepository $sliderRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $slider->getId(), $request->request->get('_token'))) {
            $sliderRepository->delete($slider);
        }
        return $this->redirectToRoute('app_slider_index', [], Response::HTTP_SEE_OTHER);
    }
    // API Banniere
    #[Route('admin/API/slider', name: 'app_api_slider', methods: ['GET'])]
    public function api(SliderRepository $sliderRepository, SerializerInterface $serialiser): Response
    {
        $sliders = $sliderRepository->findAll();
        $data = $serialiser->serialize($sliders, 'json');
        return new JsonResponse($data, 200, [], true);
    }
}
