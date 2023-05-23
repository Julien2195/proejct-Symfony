<?php
// src/Controller/RegistrationController.php
namespace App\Controller;

use App\Form\InscriptionUserType;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class InscriptionController extends AbstractController
{

    #[Route('/inscription', name: "app_inscription")]
    public function register(Request $request, UserPasswordHasherInterface $passwordEncoder, EntityManagerInterface $entityManager)
    {
        // 1) build the form
        $user = new User();

        $form = $this->createForm(InscriptionUserType::class, $user);

        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $submittedToken = $request->request->get('token');

            // 'delete-item' is the same value used in the template to generate the token
            if ($this->isCsrfTokenValid('delete-item', $submittedToken)) {
                // ... do something, like deleting an object
            }

            // 3) Encode the password (you could also do this via Doctrine listener)
            $password = $passwordEncoder->hashPassword($user, $user->getPassword());
            $user->setPassword($password);

            // 4) save the User!

            $entityManager->persist($user);
            $entityManager->flush();

            // ... do any other work - like sending them an email, etc
            // maybe set a "flash" success message for the user

            return $this->redirectToRoute('app_home');
        }

        return $this->render('inscription.html.twig', ['form' => $form->createView()]);
    }
}
